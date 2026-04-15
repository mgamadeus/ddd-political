<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Services\PoliticalEntities;

use DDD\Domain\Base\Entities\Translatable\Translatable;
use DDD\Domain\Base\Services\EntitiesService;
use DDD\Domain\Common\Entities\PoliticalEntities\Countries\Country;
use DDD\Domain\Common\Entities\PoliticalEntities\States\State;
use DDD\Domain\Common\Entities\PoliticalEntities\States\States;
use DDD\Domain\Common\Repo\Argus\PoliticalEntities\ArgusState;
use DDD\Domain\Common\Repo\DB\PoliticalEntities\States\DBState;
use DDD\Domain\Common\Repo\DB\PoliticalEntities\States\DBStates;
use DDD\Infrastructure\Exceptions\BadRequestException;
use DDD\Infrastructure\Exceptions\InternalErrorException;
use DDD\Infrastructure\Exceptions\NotFoundException;
use DDD\Infrastructure\Services\DDDService;
use Doctrine\ORM\Mapping\Entity;
use ReflectionException;

/**
 * Service for managing State entities
 *
 * @method State find(int|string|null $entityId, bool $useEntityRegistrCache = true)
 * @method States findAll(?int $offset = null, $limit = null, bool $useEntityRegistrCache = true)
 * @method State update(Entity $entity)
 * @method DBState getEntityRepoClassInstance()
 * @method DBStates getEntitySetRepoClassInstance()
 */
class StatesService extends EntitiesService
{
    public const string DEFAULT_ENTITY_CLASS = State::class;

    /**
     * Finds an existing State by shortCode or name within a country, or creates a new one via geocoding.
     * Updates the localized name translation for the given language code.
     *
     * If the State does not exist, it is geocoded using the country's default locale via ArgusState,
     * then persisted with the localized name translation. If the State exists but the localized name
     * for the given language is missing or differs, the translation is updated.
     *
     * @param string $currentLanguageCode Language code for the localized name (e.g., 'de', 'en')
     * @param Country $country The country the state belongs to
     * @param string|null $localizedName The state name in the given language (e.g., 'Bayern', 'Bavaria')
     * @param string|null $shortCode The state's short code (e.g., 'BY', 'CA')
     * @return State|null The found or created State, or null if geocoding fails
     * @throws BadRequestException If neither localizedName nor shortCode is provided
     */
    public function findOrCreateStateAndUpdateLocalizedName(
        string $currentLanguageCode,
        Country $country,
        string $localizedName = null,
        string $shortCode = null,
    ): ?State {
        if (!($localizedName || $shortCode)) {
            if ($this->throwErrors) {
                throw new BadRequestException('Either localizedName or shortCode are required');
            }
            return null;
        }
        $state = null;
        if ($shortCode) {
            $state = $this->findByShortCodeAndCountry($shortCode, $country);
        } elseif ($localizedName) {
            $state = $this->findByNameAndCountry($shortCode, $country);
        }
        if (!$state) {
            $state = new State();
            if ($localizedName) {
                $state->name = $localizedName;
            }
            if ($shortCode) {
                $state->shortCode = $shortCode;
            }
            $state->country = $country;
            $state->countryId = $country->id;
            $state = $this->geoCodeStateUsingDefaultLocale($state);
            if (!$state) {
                if ($this->throwErrors) {
                    throw new NotFoundException('State not found');
                }
                return null;
            }
            DDDService::instance()->deactivateEntityRightsRestrictions();
            Translatable::setTranslationSettingsSnapshot();
            Translatable::setCurrentCountryCode(null);
            Translatable::setCurrentLanguageCode($state->country->getDefaultLanguage()->languageCode);
            $state->name = $localizedName;
            $state->setTranslationForProperty('name', $localizedName, $currentLanguageCode);
            $state->update();
            Translatable::restoreTranslationSettingsSnapshot();
            DDDService::instance()->restoreEntityRightsRestrictionsStateSnapshot();
            return $state;
        } else {
            $currentLocalizedName = $state->getTranslationForProperty('name', $currentLanguageCode);
            if (!$currentLocalizedName || $currentLocalizedName !== $localizedName) {
                DDDService::instance()->deactivateEntityRightsRestrictions();
                $state->setTranslationForProperty('name', $localizedName, $currentLanguageCode);
                $state->update();
                DDDService::instance()->restoreEntityRightsRestrictionsStateSnapshot();
            }
        }
        return $state;
    }

    /**
     * Finds a State by its shortCode within a specific country
     *
     * @param string $shortCode The state's short code (e.g., 'BY', 'NRW', 'CA')
     * @param Country $country The country to search within
     * @return State|null The matching State or null if not found
     */
    public function findByShortCodeAndCountry(string $shortCode, Country $country): ?State
    {
        $dbState = $this->getEntityRepoClassInstance();
        $queryBuilder = $dbState->createQueryBuilder();
        $alias = $dbState::getBaseModelAlias();
        $queryBuilder->andWhere(
            "{$alias}.shortCode = :shortCode AND {$alias}.countryId = :countryId 
            "
        )->setParameter('shortCode', $shortCode)->setParameter('countryId', $country->id);
        return $dbState->find($queryBuilder);
    }

    /**
     * Finds a State by name within a specific country using FULLTEXT search on the
     * #[Translatable] name column in BOOLEAN MODE for exact token matching.
     *
     * @param string $name The localized state name to search for (e.g., 'Bayern', 'Bavaria')
     * @param Country $country The country to search within
     * @return State|null The matching State or null if not found
     */
    public function findByNameAndCountry(string $name, Country $country): ?State
    {
        $dbState = $this->getEntityRepoClassInstance();
        $queryBuilder = $dbState->createQueryBuilder();
        $alias = $dbState::getBaseModelAlias();
        // FULLTEXT search on name column (BOOLEAN MODE for exact token matching)
        $queryBuilder->andWhere(
            "MATCH ({$alias}.name) AGAINST (:searchName IN BOOLEAN MODE) > 0
            AND {$alias}.countryId = :countryId 
            "
        )->setParameter('searchName', $name)->setParameter('countryId', $country->id);
        return $dbState->find($queryBuilder);
    }

    /**
     * Geocodes the state utilizing the default locale of it' Country
     * @param State $state
     * @return State|null
     * @throws BadRequestException
     * @throws InternalErrorException
     * @throws ReflectionException
     */
    public function geoCodeStateUsingDefaultLocale(State $state): ?State
    {
        if (!(isset($state->countryId) || isset($state->country))) {
            if ($this->throwErrors) {
                throw new BadRequestException('State has to contain a Country in in order to get default Locale');
            }
            return null;
        }
        $state->setCurrentLanguageCode($state->country->getDefaultLanguage()->languageCode);
        $argusState = new ArgusState();
        $argusState = $argusState->fromEntity($state);
        $argusState->argusLoad();
        if ($argusState->getArgusSettings()->isLoadedSuccessfully) {
            $argusState->setSlugBasedOnNameAndCountry();
            return $argusState->toEntity();
        }
        return null;
    }
}
