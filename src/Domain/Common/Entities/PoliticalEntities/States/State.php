<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Entities\PoliticalEntities\States;

use DDD\Domain\Common\Entities\PoliticalEntities\Countries\Country;
use DDD\Domain\Common\Entities\Roles\Role;
use DDD\Domain\Common\Repo\Argus\PoliticalEntities\ArgusState;
use DDD\Domain\Common\Repo\DB\PoliticalEntities\States\DBState;
use DDD\Domain\Common\Services\PoliticalEntities\StatesService;
use DDD\Domain\Base\Entities\Attributes\NoRecursiveUpdate;
use DDD\Domain\Base\Entities\Attributes\RolesRequiredForUpdate;
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
 * State in terms of an administrative area within a country
 *
 * @method static StatesService getService()
 * @method static DBState getRepoClassInstance(string $repoType = null)
 */
#[LazyLoadRepo(LazyLoadRepo::DB, DBState::class)]
#[LazyLoadRepo(LazyLoadRepo::ARGUS, ArgusState::class)]
#[RolesRequiredForUpdate(Role::ADMIN)]
#[NoRecursiveUpdate]
class State extends Entity
{
    use TranslatableTrait;

    /** @var string|null The state's full name (multilingual) */
    #[Translatable(fullTextIndex: true)]
    public ?string $name;

    /** @var string|null The state's slug */
    #[DatabaseIndex(indexType: DatabaseIndex::TYPE_UNIQUE)]
    public ?string $slug;

    /** @var string|null The short name of the state, e.g. NRW, NY, CA, BY */
    public ?string $shortCode;

    /** @var int|null The id of the country the state is located in */
    public ?int $countryId;

    /** @var string|null The Google Place id of the Locality */
    #[DatabaseIndex(indexType: DatabaseIndex::TYPE_UNIQUE)]
    public ?string $placeId;

    /** @var Country|null The country the state is located in */
    #[LazyLoad]
    #[HideProperty]
    public ?Country $country;

    /** @var GeoPoint|null GeoPoint representing geographical latitude and longitude (center of the state) */
    #[DatabaseColumn(allowsNull: false)]
    public ?GeoPoint $geoPoint;

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
    }

    public function uniqueKey(): string
    {
        $key = '';
        if (isset($this->name)) {
            $key = $this->name;
        }
        if (isset($this->shortCode)) {
            $key .= '_' . $this->shortCode;
        }
        if (isset($this->currentLanguageCode)) {
            $key .= '_' . $this->currentLanguageCode;
        }
        if (isset($this->country->shortCode)) {
            $key .= '_' . $this->country->shortCode;
        }
        return self::uniqueKeyStatic($key);
    }

    public function setSlugBasedOnNameAndCountry(): void
    {
        $slug = '';
        if (isset($this->countryId) || isset($this->country)) {
            $slug = $this->country->shortCode . '-';
            if (isset($this->shortCode)) {
                $slug .= $this->shortCode;
            }
        }
        $this->slug = Datafilter::slug($slug);
    }

    public function getCurrentLanguageCode(): ?string
    {
        if (!isset($this->currentLanguageCode)) {
            return null;
        }
        return $this->currentLanguageCode;
    }

    public function setCurrentLanguageCode(string $languageCode): void
    {
        $this->currentLanguageCode = $languageCode;
    }
}
