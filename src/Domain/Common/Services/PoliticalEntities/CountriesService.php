<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Services\PoliticalEntities;

use DDD\Domain\Common\Entities\Languages\Language;
use DDD\Domain\Common\Entities\Locales\Locale;
use DDD\Domain\Common\Entities\PoliticalEntities\Countries\Countries;
use DDD\Domain\Common\Entities\PoliticalEntities\Countries\Country;
use DDD\Domain\Common\Entities\PoliticalEntities\Countries\CountryAddressSetting;
use DDD\Domain\Common\Entities\PoliticalEntities\Countries\CountrySetting;
use DDD\Domain\Common\Repo\DB\PoliticalEntities\Countries\DBCountries;

use DDD\Domain\Common\Repo\DB\PoliticalEntities\Countries\DBCountry;
use DDD\Domain\Base\Entities\Entity;
use DDD\Domain\Base\Services\EntitiesService;
use DDD\Infrastructure\Libs\Config;

/**
 * Service for managing Country entities
 *
 * @method Country find(int|string|null $entityId, bool $useEntityRegistrCache = true)
 * @method Countries findAll(?int $offset = null, $limit = null, bool $useEntityRegistrCache = true)
 * @method Country update(Entity $entity)
 * @method DBCountry getEntityRepoClassInstance()
 * @method DBCountries getEntitySetRepoClassInstance()
 */
class CountriesService extends EntitiesService
{
    public const string DEFAULT_ENTITY_CLASS = Country::class;

    /**
     * Imports all countries from the config file (config/app/Common/Countries.php).
     * For each country entry: if a country with the same shortCode already exists,
     * it is updated with the config values; otherwise a new Country is created.
     *
     * Regular countries (type COUNTRY) are imported first, then territories
     * (type TERRITORY) so that parentCountryCode can be resolved to an ID.
     *
     * Resolves politicalSubRegionSlug (preferred) or politicalRegionSlug to politicalRegionId.
     * Requires PoliticalRegions to be imported first.
     */
    public function importCountriesFromConfig(
        PoliticalRegionsService $politicalRegionsService
    ): Countries {
        $importedCountries = new Countries();

        $countriesConfig = Config::get('Common.Political.Countries.countries');
        if (!is_array($countriesConfig) || empty($countriesConfig)) {
            return $importedCountries;
        }

        // Pre-build slug-to-ID lookup for political regions
        $regionIdBySlug = [];
        $allRegions = $politicalRegionsService->findAll();
        if ($allRegions) {
            foreach ($allRegions->getElements() as $region) {
                $regionIdBySlug[$region->slug] = $region->id;
            }
        }

        // Split into regular countries and territories so parents are imported first
        $regularCountries = [];
        $territories = [];
        foreach ($countriesConfig as $key => $countryData) {
            $type = $countryData['type'] ?? Country::TYPE_COUNTRY;
            if ($type === Country::TYPE_TERRITORY) {
                $territories[$key] = $countryData;
            } else {
                $regularCountries[$key] = $countryData;
            }
        }

        // Pass 1: import regular countries
        foreach ($regularCountries as $countryData) {
            $country = $this->importSingleCountry($countryData, $regionIdBySlug);
            if ($country !== null) {
                $importedCountries->add($country);
            }
        }

        // Pass 2: import territories (parents are now guaranteed to exist)
        foreach ($territories as $countryData) {
            $country = $this->importSingleCountry($countryData, $regionIdBySlug);
            if ($country !== null) {
                $importedCountries->add($country);
            }
        }

        return $importedCountries;
    }

    /**
     * Imports or updates a single country from config data via upsert.
     *
     * @param array $countryData Config entry for one country
     * @param array<string, int> $regionIdBySlug PoliticalRegion slug-to-ID lookup
     * @return Country|null Null if shortCode is missing
     */
    protected function importSingleCountry(array $countryData, array $regionIdBySlug): ?Country
    {
        $shortCode = $countryData['shortCode'] ?? null;
        if ($shortCode === null) {
            return null;
        }

        $nameValue = is_array($countryData['name'] ?? null)
            ? ($countryData['name']['en'] ?? null)
            : ($countryData['name'] ?? null);

        // Resolve parent country for territories
        $parentCountryId = null;
        $parentCountryCode = $countryData['parentCountryCode'] ?? null;
        if ($parentCountryCode !== null) {
            $parentCountry = $this->findByShortCode($parentCountryCode);
            $parentCountryId = $parentCountry?->id;
        }

        // Resolve political region: prefer politicalSubRegionSlug (most specific), fall back to politicalRegionSlug
        $politicalRegionId = null;
        $politicalRegionSlug = $countryData['politicalSubRegionSlug'] ?? $countryData['politicalRegionSlug'] ?? null;
        if ($politicalRegionSlug !== null) {
            $politicalRegionId = $regionIdBySlug[$politicalRegionSlug] ?? null;
        }

        $country = new Country();
        $country->shortCode = $shortCode;
        $country->name = $nameValue;
        $country->slug = $countryData['slug'] ?? null;
        $country->type = $countryData['type'] ?? Country::TYPE_COUNTRY;
        $country->isoCode = $countryData['isoCode'] ?? null;
        $country->tld = $countryData['tld'] ?? null;
        $country->commonTld = $countryData['commonTld'] ?? null;
        $country->phonePrefix = $countryData['phonePrefix'] ?? null;
        $country->nativeLanguageCode = $countryData['nativeLanguageCode'] ?? null;
        $country->parentCountryId = $parentCountryId;
        $country->politicalRegionId = $politicalRegionId;
        $country->setting = $this->buildCountrySetting($countryData['setting'] ?? null);
        $country->addressSetting = $this->buildCountryAddressSetting($countryData['addressSetting'] ?? null);
        $this->applyNameTranslations($country, $countryData['name'] ?? null);

        return $this->update($country);
    }

    /**
     * Builds a CountrySetting value object from config data.
     */
    protected function buildCountrySetting(?array $settingData): ?CountrySetting
    {
        if (!is_array($settingData)) {
            return null;
        }
        $setting = new CountrySetting();
        $setting->unitSystem = $settingData['unitSystem'] ?? CountrySetting::UNIT_SYSTEM_METRIC;
        $setting->timeSystem = $settingData['timeSystem'] ?? CountrySetting::TIME_SYSTEM_24H;
        $setting->firstDayOfWeek = $settingData['firstDayOfWeek'] ?? CountrySetting::FIRST_DAY_OF_WEEK_MONDAY;
        $setting->addressFormat = $settingData['addressFormat'] ?? null;
        $setting->appDefaultLanguageCode = $settingData['appDefaultLanguageCode'] ?? null;
        $setting->isActive = $settingData['isActive'] ?? true;
        $setting->priority = $settingData['priority'] ?? 0;
        $setting->firstnameBeforeLastname = $settingData['firstnameBeforeLastname'] ?? true;
        return $setting;
    }

    /**
     * Builds a CountryAddressSetting value object from config data.
     */
    protected function buildCountryAddressSetting(?array $addressSettingData): ?CountryAddressSetting
    {
        if (!is_array($addressSettingData)) {
            return null;
        }
        $addressSetting = new CountryAddressSetting();
        $addressSetting->streetNoIsMandatory = $addressSettingData['streetNoIsMandatory'] ?? false;
        $addressSetting->streetIsMandatory = $addressSettingData['streetIsMandatory'] ?? false;
        $addressSetting->localityIsMandatory = $addressSettingData['localityIsMandatory'] ?? true;
        $addressSetting->postalCodeIsMandatory = $addressSettingData['postalCodeIsMandatory'] ?? true;
        $addressSetting->stateIsMandatory = $addressSettingData['stateIsMandatory'] ?? false;
        $addressSetting->countyIsMandatory = $addressSettingData['countyIsMandatory'] ?? false;
        $addressSetting->countyShortCodeIsMandatory = $addressSettingData['countyShortCodeIsMandatory'] ?? false;
        $addressSetting->subCountyIsMandatory = $addressSettingData['subCountyIsMandatory'] ?? false;
        $addressSetting->streetNoIsBeforeStreet = $addressSettingData['streetNoIsBeforeStreet'] ?? false;
        $addressSetting->localityIsBeforePostalcode = $addressSettingData['localityIsBeforePostalcode'] ?? false;
        $addressSetting->streetNoFormat = $addressSettingData['streetNoFormat'] ?? CountryAddressSetting::STREET_NO_FORMAT_STREET_FIRST;
        $addressSetting->addressFormat = $addressSettingData['addressFormat'] ?? null;
        return $addressSetting;
    }

    /**
     * Sets translations for the name property from a config name array.
     *
     * @param Country $country
     * @param array<string, string>|string|null $nameData Config value — array of langCode => name, or plain string
     */
    protected function applyNameTranslations(Country $country, array|string|null $nameData): void
    {
        if (!is_array($nameData)) {
            return;
        }
        foreach ($nameData as $langCode => $translatedName) {
            $country->setTranslationForProperty('name', $translatedName, $langCode);
        }
    }

    /**
     * Find a country by its ISO 3166-1 alpha-2 short code
     *
     * @param string $shortCode 2-letter code (e.g. 'de', 'us', 'at')
     * @return Country|null
     */
    public function findByShortCode(string $shortCode): ?Country
    {
        $repoClass = $this->getEntityRepoClassInstance();
        $queryBuilder = $repoClass::createQueryBuilder();
        $baseModelAlias = $repoClass::getBaseModelAlias();
        $queryBuilder->andWhere("$baseModelAlias.shortCode = :shortCode");
        $queryBuilder->setParameter('shortCode', $shortCode);

        return $repoClass->find($queryBuilder);
    }

    /**
     * Find the default Locale for a given country
     * @param Country $country
     * @return Locale|null
     */
    public function findDefaultLocaleForCountry(Country $country): ?Locale
    {
        $localesService = Locale::getService();
        return $localesService->findDefaultLocaleForCountry($country);
    }

    /**
     * Find the default Language for a given country
     * @param Country $country
     * @return Language|null
     */
    public function findDefaultLanguageForCountry(Country $country): ?Language
    {
        $localesService = Locale::getService();
        $locale = $localesService->findDefaultLocaleForCountry($country);
        return $locale?->language;
    }
}
