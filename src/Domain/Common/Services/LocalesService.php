<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Services;

use DDD\Domain\Common\Entities\Languages\Language;
use DDD\Domain\Common\Entities\Languages\Languages;
use DDD\Domain\Common\Entities\Locales\Locale;
use DDD\Domain\Common\Entities\Locales\Locales;
use DDD\Domain\Common\Entities\PoliticalEntities\Countries\Country;
use DDD\Domain\Common\Repo\DB\Locales\DBLocale;
use DDD\Domain\Common\Repo\DB\Locales\DBLocales;

use DDD\Domain\Common\Services\PoliticalEntities\CountriesService;
use DDD\Domain\Base\Entities\Entity;
use DDD\Domain\Base\Services\EntitiesService;
use DDD\Infrastructure\Libs\Config;

/**
 * Service for managing Locale entities
 *
 * @method Locale find(int|string|null $entityId, bool $useEntityRegistrCache = true)
 * @method Locales findAll(?int $offset = null, $limit = null, bool $useEntityRegistrCache = true)
 * @method Locale update(Entity $entity)
 * @method DBLocale getEntityRepoClassInstance()
 * @method DBLocales getEntitySetRepoClassInstance()
 */
class LocalesService extends EntitiesService
{
    public const DEFAULT_ENTITY_CLASS = Locale::class;

    /**
     * Find a locale by its composite key (languageCode + countryShortCode)
     *
     * @param string $languageCode ISO 639-1 code (e.g. 'de', 'en')
     * @param string $countryShortCode ISO 3166-1 alpha-2 code (e.g. 'de', 'us')
     * @return Locale|null
     */
    public function findByLanguageCodeAndCountryShortCode(string $languageCode, string $countryShortCode): ?Locale
    {
        $repoClass = $this->getEntityRepoClassInstance();
        $queryBuilder = $repoClass::createQueryBuilder();
        $baseModelAlias = $repoClass::getBaseModelAlias();
        $queryBuilder->andWhere("{$baseModelAlias}.languageCode = :languageCode");
        $queryBuilder->andWhere("{$baseModelAlias}.countryShortCode = :countryShortCode");
        $queryBuilder->setParameter('languageCode', $languageCode);
        $queryBuilder->setParameter('countryShortCode', $countryShortCode);

        return $repoClass->find($queryBuilder);
    }

    /**
     * Imports all locales from the config file (config/app/Common/Locales.php).
     * For each locale entry: if a locale with the same languageCode + countryShortCode
     * already exists, it is updated with the config values; otherwise a new Locale is created.
     *
     * Resolves languageId via LanguagesService::findByLanguageCode() and
     * countryId via CountriesService::findByShortCode().
     *
     * @param LanguagesService $languagesService Service to resolve languageCode -> languageId
     * @param CountriesService $countriesService Service to resolve countryShortCode -> countryId
     */
    public function importLocalesFromConfig(
        LanguagesService $languagesService,
        CountriesService $countriesService
    ): Locales {
        $importedLocales = new Locales();

        $localesConfig = Config::get('Common.Political.Locales.locales');
        if (!is_array($localesConfig) || empty($localesConfig)) {
            return $importedLocales;
        }

        foreach ($localesConfig as $localeData) {
            $languageCode = $localeData['languageCode'] ?? null;
            $countryShortCode = $localeData['countryShortCode'] ?? null;
            if ($languageCode === null || $countryShortCode === null) {
                continue;
            }

            // Resolve languageId from languageCode
            $language = $languagesService->findByLanguageCode($languageCode);
            $languageId = $language?->id;

            // Resolve countryId from countryShortCode
            $country = $countriesService->findByShortCode($countryShortCode);
            $countryId = $country?->id;

            $existingLocale = $this->findByLanguageCodeAndCountryShortCode($languageCode, $countryShortCode);

            // name is #[Translatable] (typed ?string), config has it as string
            $nameValue = $localeData['name'] ?? null;

            if ($existingLocale !== null) {
                // Update existing locale with config values
                $existingLocale->name = $nameValue ?? $existingLocale->name;
                $existingLocale->languageId = $languageId ?? $existingLocale->languageId;
                $existingLocale->countryId = $countryId ?? $existingLocale->countryId;
                $existingLocale->isDefaultLocaleForLanguage = $localeData['isDefaultLocaleForLanguage'] ?? $existingLocale->isDefaultLocaleForLanguage;
                $existingLocale->isDefaultLocaleForCountry = $localeData['isDefaultLocaleForCountry'] ?? $existingLocale->isDefaultLocaleForCountry;

                $updatedLocale = $this->update($existingLocale);
                $importedLocales->add($updatedLocale);
            } else {
                // Create new locale from config
                $locale = new Locale();
                $locale->languageCode = $languageCode;
                $locale->countryShortCode = $countryShortCode;
                $locale->languageId = $languageId;
                $locale->countryId = $countryId;
                $locale->name = $nameValue;
                $locale->isDefaultLocaleForLanguage = $localeData['isDefaultLocaleForLanguage'] ?? false;
                $locale->isDefaultLocaleForCountry = $localeData['isDefaultLocaleForCountry'] ?? false;

                $createdLocale = $this->update($locale);
                $importedLocales->add($createdLocale);
            }
        }

        return $importedLocales;
    }

    /**
     * Find the default locale for a given language
     *
     * @param Language $language
     * @return Locale|null
     */
    public function findDefaultLocaleForLanguage(Language $language): ?Locale
    {
        $repoClass = $this->getEntityRepoClassInstance();
        $queryBuilder = $repoClass::createQueryBuilder();
        $baseModelAlias = $repoClass::getBaseModelAlias();

        $queryBuilder->andWhere("{$baseModelAlias}.languageId = :languageId");
        $queryBuilder->andWhere("{$baseModelAlias}.isDefaultLocaleForLanguage = :isDefault");
        $queryBuilder->setParameter('languageId', $language->id);
        $queryBuilder->setParameter('isDefault', true);
        return $repoClass->find($queryBuilder);
    }

    /**
     * Find all active Locales
     *
     * @return Locales
     */
    public function findActiveLocales(): Locales
    {
        $repoClass = $this->getEntitySetRepoClassInstance();
        $queryBuilder = $repoClass::createQueryBuilder();
        $baseModelAlias = $repoClass::getBaseModelAlias();

        $queryBuilder->andWhere("{$baseModelAlias}.isActive = :isActive");
        $queryBuilder->setParameter('isActive', true);

        return $repoClass->find($queryBuilder);
    }

    /**
     * Find the default locale for a given country
     * @param Country $country
     * @return Locale|null
     */
    public function findDefaultLocaleForCountry(Country $country): ?Locale
    {
        $repoClass = $this->getEntityRepoClassInstance();
        $queryBuilder = $repoClass::createQueryBuilder();
        $baseModelAlias = $repoClass::getBaseModelAlias();

        $queryBuilder->andWhere("{$baseModelAlias}.countryId = :countryId");
        $queryBuilder->andWhere("{$baseModelAlias}.isDefaultLocaleForCountry = :isDefault");
        $queryBuilder->setParameter('countryId', $country->id);
        $queryBuilder->setParameter('isDefault', true);
        return $repoClass->find($queryBuilder);
    }
}
