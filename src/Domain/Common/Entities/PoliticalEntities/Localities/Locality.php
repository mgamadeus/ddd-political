<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Entities\PoliticalEntities\Localities;

use DDD\Domain\Common\Entities\PoliticalEntities\Countries\Country;
use DDD\Domain\Common\Entities\PoliticalEntities\States\State;
use DDD\Domain\Common\Entities\Roles\Role;
use DDD\Domain\Common\Repo\Argus\PoliticalEntities\ArgusLocality;
use DDD\Domain\Common\Repo\DB\PoliticalEntities\Localities\DBLocality;
use DDD\Domain\Common\Services\PoliticalEntities\LocalitiesService;
use DDD\Domain\Base\Entities\Attributes\NoRecursiveUpdate;
use DDD\Domain\Base\Entities\Attributes\RolesRequiredForUpdate;
use DDD\Domain\Base\Entities\ChangeHistory\ChangeHistoryTrait;
use DDD\Domain\Base\Entities\Entity;
use DDD\Domain\Base\Entities\LazyLoad\LazyLoad;
use DDD\Domain\Base\Entities\LazyLoad\LazyLoadRepo;
use DDD\Domain\Base\Entities\Translatable\Translatable;
use DDD\Domain\Base\Entities\Translatable\TranslatableTrait;
use DDD\Domain\Base\Repo\DB\Database\DatabaseColumn;
use DDD\Domain\Base\Repo\DB\Database\DatabaseIndex;
use DDD\Domain\Common\Entities\GeoEntities\GeoPoint;
use DDD\Infrastructure\Libs\Datafilter;
use DDD\Infrastructure\Traits\Serializer\Attributes\HideProperty;

/**
 * @method static LocalitiesService getService()
 * @method static DBLocality getRepoClassInstance(string $repoType = null)
 */
#[LazyLoadRepo(LazyLoadRepo::DB, DBLocality::class)]
#[LazyLoadRepo(LazyLoadRepo::ARGUS, ArgusLocality::class)]
#[RolesRequiredForUpdate(Role::ADMIN)]
#[NoRecursiveUpdate]
class Locality extends Entity
{
    use ChangeHistoryTrait, TranslatableTrait;

    /** @var string|null The locality's name (multilingual) */
    #[Translatable(fullTextIndex: true)]
    public ?string $name;

    /** @var string|null The locality's slug */
    #[DatabaseIndex(indexType: DatabaseIndex::TYPE_UNIQUE)]
    public ?string $slug;

    /** @var int|null The id of the state the locality is located in */
    public ?int $stateId;

    /** @var int|null The id of the country the locality is located in */
    public ?int $countryId;

    /** @var string|null The Google Place id of the Locality */
    #[DatabaseIndex(indexType: DatabaseIndex::TYPE_UNIQUE)]
    public ?string $placeId;

    /** @var GeoPoint GeoPoint representing geographical latitude and longitude */
    #[DatabaseColumn(allowsNull: false)]
    public GeoPoint $geoPoint;

    /** @var State|null State in which the locality is located */
    #[LazyLoad]
    #[HideProperty]
    public ?State $state;

    /** @var Country|null Country in which the locality is located */
    #[LazyLoad]
    #[HideProperty]
    public ?Country $country;

    /** @var string|null Current Language code, e.g. for Geocoding purposes */
    protected ?string $currentLanguageCode;

    /**
     * Sets name and by this also slug
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
        $this->slug = Datafilter::alias($name);
    }

    /**
     * Returns a unique key based on name, placeId, language and country
     *
     * @return string
     */
    public function uniqueKey(): string
    {
        $key = '';
        if (isset($this->name)) {
            $key = $this->name;
        }
        if (isset($this->slug)) {
            $key .= '_' . $this->slug;
        }
        if (isset($this->placeId)) {
            $key .= '_' . $this->placeId;
        }
        if (isset($this->country->shortCode)) {
            $key .= '_' . $this->country->shortCode;
        }
        if (isset($this->currentLanguageCode)) {
            $key .= '_' . $this->currentLanguageCode;
        }
        return self::uniqueKeyStatic($key);
    }

    /**
     * Sets the slug based on the country short code and locality name
     *
     * @return void
     */
    public function setSlugBasedOnNameStateAndCountry(): void
    {
        $slug = '';
        if (isset($this->countryId) || isset($this->country)) {
            $slug = $this->country->shortCode . '-';
        }
        if (isset($this->stateId) || isset($this->state)) {
            $slug .= $this->state->shortCode . '-';
        }
        if (isset($this->name)) {
            $slug .= Datafilter::slug($this->name);
        }
        $this->slug = Datafilter::slug($slug);
    }

    /**
     * Returns the current language code
     *
     * @return string|null
     */
    public function getCurrentLanguageCode(): ?string
    {
        if (!isset($this->currentLanguageCode)) {
            return null;
        }
        return $this->currentLanguageCode;
    }

    /**
     * Sets the current language code
     *
     * @param string $languageCode
     * @return void
     */
    public function setCurrentLanguageCode(string $languageCode): void
    {
        $this->currentLanguageCode = $languageCode;
    }

}
