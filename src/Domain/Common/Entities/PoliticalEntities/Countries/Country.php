<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Entities\PoliticalEntities\Countries;

use DDD\Domain\Common\Entities\Languages\Language;
use DDD\Domain\Common\Entities\Locales\Locale;
use DDD\Domain\Common\Entities\Locales\Locales;
use DDD\Domain\Common\Entities\PoliticalEntities\PoliticalRegions\PoliticalRegion;
use DDD\Domain\Common\Entities\Roles\Role;
use DDD\Domain\Common\Repo\DB\PoliticalEntities\Countries\DBCountry;
use DDD\Domain\Common\Services\PoliticalEntities\CountriesService;
use DDD\Domain\Base\Entities\Attributes\NoRecursiveUpdate;
use DDD\Domain\Base\Entities\Attributes\RolesRequiredForUpdate;
use DDD\Domain\Base\Entities\Entity;
use DDD\Domain\Base\Entities\LazyLoad\LazyLoad;
use DDD\Domain\Base\Entities\LazyLoad\LazyLoadRepo;
use DDD\Domain\Base\Entities\QueryOptions\QueryOptionsTrait;
use DDD\Domain\Base\Entities\Translatable\Translatable;
use DDD\Domain\Base\Entities\Translatable\TranslatableTrait;
use DDD\Domain\Base\Repo\DB\Database\DatabaseIndex;
use DDD\Infrastructure\Validation\Constraints\Choice;

/**
 * @method static CountriesService getService()
 * @method static DBCountry getRepoClassInstance(string $repoType = null)
 */
#[NoRecursiveUpdate]
#[RolesRequiredForUpdate(Role::ADMIN)]
#[LazyLoadRepo(LazyLoadRepo::DB, DBCountry::class)]
class Country extends Entity
{
    use TranslatableTrait, QueryOptionsTrait;

    /** @var string Regular country type */
    public const string TYPE_COUNTRY = 'COUNTRY';

    /** @var string Dependent territory or overseas region type */
    public const string TYPE_TERRITORY = 'TERRITORY';

    /** @var string|null Country name (multilingual) */
    #[Translatable(fullTextIndex: true)]
    public ?string $name;

    /** @var string|null Country slug */
    #[DatabaseIndex(indexType: DatabaseIndex::TYPE_UNIQUE)]
    public ?string $slug;

    /** @var int|null Parent country id */
    public ?int $parentCountryId;

    /** @var Country|null In case that country is a region, e.g. French Guiana, parent Country is France */
    #[LazyLoad(addAsParent: true)]
    public ?Country $parentCountry;

    /** @var int|null Political region id (points to the most specific level, typically a sub-region) */
    public ?int $politicalRegionId;

    /** @var PoliticalRegion|null Political region */
    #[LazyLoad(addAsParent: true)]
    public ?PoliticalRegion $politicalRegion;

    /** @var string|null Type of country: regular country or dependent territory */
    #[Choice(choices: [self::TYPE_COUNTRY, self::TYPE_TERRITORY])]
    public ?string $type = self::TYPE_COUNTRY;

    /**
     * @var string|null Official top level domain
     * @example uk, de, us
     */
    #[DatabaseIndex(indexType: DatabaseIndex::TYPE_UNIQUE)]
    public ?string $tld;

    /**
     * @var string|null Common top level domain, can be different for some countries as USA has .com or UK uses co.uk
     * @example de, at, co.uk, com
     */
    public ?string $commonTld;

    /**
     * @var string|null 2-letter ISO code
     * @example de, us
     */
    #[DatabaseIndex(indexType: DatabaseIndex::TYPE_UNIQUE)]
    public ?string $shortCode;

    /**
     * @var string|null 3-letter ISO code
     * @example usa, fra, deu
     */
    #[DatabaseIndex(indexType: DatabaseIndex::TYPE_UNIQUE)]
    public ?string $isoCode;

    /**
     * @var int|null International phone prefix without 00 or +
     * @example 49, 1, 31
     */
    public ?int $phonePrefix;


    /**
     * @var string|null The native language of this country, e.g. de for German
     */
    public ?string $nativeLanguageCode;

    /** @var CountrySetting|null Detailed country settings */
    public ?CountrySetting $setting;

    /** @var CountryAddressSetting|null Detailed address settings */
    public ?CountryAddressSetting $addressSetting;

    /** @var Locales The locales supported for this country */
    #[LazyLoad(LazyLoadRepo::DB)]
    public Locales $locales;

    /**
     * Find the default Locale for a given country
     * @return Locale|null
     */
    public function getDefaultLocale(): ?Locale
    {
        return self::getService()->findDefaultLocaleForCountry($this);
    }

    /**
     * Find the default Language for a given country
     * @return Language|null
     */
    public function getDefaultLanguage(): ?Language
    {
        return self::getService()->findDefaultLanguageForCountry($this);
    }
}
