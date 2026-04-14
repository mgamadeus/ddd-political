<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Services\PoliticalEntities;

use DDD\Domain\Common\Entities\PoliticalEntities\Localities\Localities;
use DDD\Domain\Common\Entities\PoliticalEntities\Localities\Locality;
use DDD\Domain\Common\Entities\PoliticalEntities\Countries\Country;
use DDD\Domain\Common\Entities\PoliticalEntities\States\State;
use DDD\Domain\Common\Repo\Argus\PoliticalEntities\ArgusLocality;
use DDD\Domain\Common\Repo\DB\PoliticalEntities\Localities\DBLocalities;
use DDD\Domain\Common\Repo\DB\PoliticalEntities\Localities\DBLocality;
use DDD\Infrastructure\Services\AppService;
use DDD\Domain\Base\Entities\Translatable\Translatable;
use DDD\Domain\Base\Services\EntitiesService;
use DDD\Domain\Common\Entities\GeoEntities\GeoPoint;
use DDD\Infrastructure\Exceptions\BadRequestException;
use DDD\Infrastructure\Exceptions\InternalErrorException;
use Google\Cloud\Core\Exception\NotFoundException;
use ReflectionException;

/**
 * Service for managing Locality entities
 *
 * @method Locality find(int|string|null $entityId, bool $useEntityRegistrCache = true)
 * @method Localities findAll(?int $offset = null, $limit = null, bool $useEntityRegistrCache = true)
 * @method Locality update(Entity $entity)
 * @method DBLocality getEntityRepoClassInstance()
 * @method DBLocalities getEntitySetRepoClassInstance()
 */
class LocalitiesService extends EntitiesService
{
    public const DEFAULT_ENTITY_CLASS = Locality::class;

    /**
     * Finds an existing Locality by placeId, name+coordinates, or name+country, or creates a new one via geocoding.
     * Updates the localized name translation for the given language code.
     *
     * Lookup priority:
     * 1. By placeId (globally unique)
     * 2. By name + geoPoint (geographic proximity within 50km radius)
     * 3. By name + country (+ optional state) via FULLTEXT search
     *
     * If the Locality does not exist, it is geocoded using the country's default locale via ArgusLocality,
     * then persisted with the localized name translation. If the Locality exists but the localized name
     * for the given language is missing or differs, the translation is updated.
     *
     * @param string $currentLanguageCode Language code for the localized name (e.g., 'de', 'en')
     * @param Country $country The country the locality belongs to
     * @param State|null $state The state the locality belongs to (optional)
     * @param string|null $localizedName The locality name in the given language (e.g., 'München', 'Munich')
     * @param string|null $placeId The Google Place ID of the locality
     * @param GeoPoint|null $geoPoint Geographic coordinates for proximity-based locality lookup
     * @return Locality|null The found or created Locality, or null if geocoding fails
     * @throws BadRequestException If neither localizedName nor placeId is provided
     */
    public function findOrCreateLocalityAndUpdateLocalizedName(
        string $currentLanguageCode,
        Country $country,
        ?State $state = null,
        ?string $localizedName = null,
        ?string $placeId = null,
        ?GeoPoint $geoPoint = null,
    ): ?Locality {
        if (!($localizedName || $placeId)) {
            if ($this->throwErrors) {
                throw new BadRequestException('Either localizedName or placeId are required');
            }
            return null;
        }

        $locality = null;
        if ($placeId) {
            $locality = $this->findByPlaceId($placeId);
        } elseif ($localizedName) {
            if ($geoPoint) {
                $locality = $this->findLocalityByNameAndCoordinates($localizedName, $geoPoint);
            }
            if (!$locality) {
                $locality = $this->findByNameAndState($localizedName, $state);
            }
        }

        if (!$locality) {
            $locality = new Locality();
            if ($localizedName) {
                $locality->name = $localizedName;
            }
            if ($placeId) {
                $locality->placeId = $placeId;
            }
            $locality->country = $country;
            $locality->countryId = $country->id;
            if ($state) {
                $locality->state = $state;
                $locality->stateId = $state->id;
            }
            if ($geoPoint) {
                $locality->geoPoint = $geoPoint;
            }
            $locality = $this->geoCodeLocalityUsingDefaultLocale($locality);
            if (!$locality) {
                if ($this->throwErrors) {
                    throw new NotFoundException('Locality not found');
                }
                return null;
            }
            AppService::instance()->deactivateEntityRightsRestrictions();
            Translatable::setTranslationSettingsSnapshot();
            Translatable::setCurrentCountryCode(null);
            Translatable::setCurrentLanguageCode($locality->country->getDefaultLanguage($locality->country)->languageCode);
            $locality->name = $localizedName;
            $locality->setTranslationForProperty('name', $localizedName, $currentLanguageCode);
            $locality->update();
            Translatable::restoreTranslationSettingsSnapshot();
            AppService::instance()->restoreEntityRightsRestrictionsStateSnapshot();
            return $locality;
        } else {
            $currentLocalizedName = $locality->getTranslationForProperty('name', $currentLanguageCode);
            if (!$currentLocalizedName || $currentLocalizedName !== $localizedName) {
                AppService::instance()->deactivateEntityRightsRestrictions();
                $locality->setTranslationForProperty('name', $localizedName, $currentLanguageCode);
                $locality->update();
                AppService::instance()->restoreEntityRightsRestrictionsStateSnapshot();
            }
        }
        return $locality;
    }

    /**
     * Finds a Locality by its Google Place ID (globally unique)
     *
     * @param string $placeId The Google Place ID
     * @return Locality|null The matching Locality or null if not found
     */
    public function findByPlaceId(string $placeId): ?Locality
    {
        $dbLocality = $this->getEntityRepoClassInstance();
        $queryBuilder = $dbLocality->createQueryBuilder();
        $alias = $dbLocality::getBaseModelAlias();
        $queryBuilder->andWhere(
            "{$alias}.placeId = :placeId"
        )->setParameter('placeId', $placeId);
        return $dbLocality->find($queryBuilder);
    }

    /**
     * Finds a Locality by name using FULLTEXT search on the #[Translatable] name column.
     * Optionally narrows results by state to disambiguate localities with the same name.
     *
     * @param string $name The localized locality name to search for (e.g., 'München', 'Munich')
     * @param State|null $state Optional state to narrow the search within
     * @return Locality|null The matching Locality or null if not found
     */
    public function findByNameAndState(string $name, ?State $state = null): ?Locality
    {
        $dbLocality = $this->getEntityRepoClassInstance();
        $queryBuilder = $dbLocality->createQueryBuilder();
        $alias = $dbLocality::getBaseModelAlias();
        $queryBuilder->andWhere(
            "MATCH ({$alias}.name) AGAINST (:searchName IN BOOLEAN MODE) > 0"
        )->setParameter('searchName', $name);
        if ($state) {
            $queryBuilder->andWhere("{$alias}.stateId = :stateId")
                ->setParameter('stateId', $state->id);
        }
        return $dbLocality->find($queryBuilder);
    }

    /**
     * Find a locality by name using FULLTEXT search combined with geographic proximity (ST_Distance_Sphere radius search).
     *
     * @param string $name Locality name in any language (e.g. "München" or "Munich")
     * @param GeoPoint $geoPoint Center point for the geographic search
     * @param float $searchRadiusInMeters Maximum distance from geoPoint in meters (default 50km)
     * @return Locality|null The closest matching locality, or null if none found
     */
    public function findLocalityByNameAndCoordinates(
        string $name,
        GeoPoint $geoPoint,
        float $searchRadiusInMeters = 50000
    ): ?Locality {
        $dbLocality = $this->getEntityRepoClassInstance();
        $queryBuilder = $dbLocality->createQueryBuilder(true);
        $alias = $dbLocality::getBaseModelAlias();

        // FULLTEXT search on name column (BOOLEAN MODE for exact token matching)
        $queryBuilder->andWhere(
            "MATCH ({$alias}.name) AGAINST (:searchName IN BOOLEAN MODE) > 0"
        );
        $queryBuilder->setParameter('searchName', $name);

        // Geographic radius filter using ST_Distance_Sphere
        $searchPointWkt = sprintf(
            'POINT(%s %s)',
            $geoPoint->lng,
            $geoPoint->lat
        );
        $queryBuilder->andWhere(
            "ST_Distance_Sphere({$alias}.geoPoint, ST_GeomFromText(:searchPoint)) <= :searchRadius"
        );
        $queryBuilder->setParameter('searchPoint', $searchPointWkt);
        $queryBuilder->setParameter('searchRadius', $searchRadiusInMeters);

        // Order by distance ascending to get the closest match
        $queryBuilder->addOrderBy(
            "ST_Distance_Sphere({$alias}.geoPoint, ST_GeomFromText(:searchPointOrder))",
            'ASC'
        );
        $queryBuilder->setParameter('searchPointOrder', $searchPointWkt);
        $queryBuilder->setMaxResults(1);

        return $dbLocality->find($queryBuilder);
    }

    /**
     * Geocodes the locality utilizing the default locale of its Country.
     * Creates an ArgusLocality, sets the language from the country's default language,
     * performs forward geocoding via the geocodeCity batch endpoint,
     * and returns the populated Locality entity.
     *
     * @param Locality $locality Locality with name and country set
     * @return Locality|null The geocoded Locality with geoPoint and placeId, or null if geocoding fails
     * @throws BadRequestException If locality has no country
     * @throws InternalErrorException
     * @throws ReflectionException
     */
    public function geoCodeLocalityUsingDefaultLocale(Locality $locality): ?Locality
    {
        if (!(isset($locality->countryId) || isset($locality->country))) {
            if ($this->throwErrors) {
                throw new BadRequestException('Locality has to contain a Country in order to get default Locale');
            }
            return null;
        }
        $locality->setCurrentLanguageCode($locality->country->getDefaultLanguage($locality->country)->languageCode);
        $argusLocality = new ArgusLocality();
        $argusLocality = $argusLocality->fromEntity($locality);
        $argusLocality->argusLoad();
        if ($argusLocality->getArgusSettings()->isLoadedSuccessfully) {
            $argusLocality->setSlugBasedOnNameStateAndCountry();
            return $argusLocality->toEntity();
        }
        return null;
    }
}
