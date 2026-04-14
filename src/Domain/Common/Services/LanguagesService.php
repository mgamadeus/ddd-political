<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Services;

use DDD\Domain\Common\Entities\Languages\Language;
use DDD\Domain\Common\Entities\Languages\Languages;
use DDD\Domain\Common\Entities\Locales\Locale;
use DDD\Domain\Common\Entities\Locales\Locales;
use DDD\Domain\Common\Repo\DB\Languages\DBLanguage;
use DDD\Domain\Common\Repo\DB\Languages\DBLanguages;

use DDD\Domain\Base\Entities\Entity;
use DDD\Domain\Base\Services\EntitiesService;
use DDD\Infrastructure\Libs\Config;

/**
 * Service for managing Language entities
 *
 * @method Language find(int|string|null $entityId, bool $useEntityRegistrCache = true)
 * @method Languages findAll(?int $offset = null, $limit = null, bool $useEntityRegistrCache = true)
 * @method Language update(Entity $entity)
 * @method DBLanguage getEntityRepoClassInstance()
 * @method DBLanguages getEntitySetRepoClassInstance()
 */
class LanguagesService extends EntitiesService
{
    public const DEFAULT_ENTITY_CLASS = Language::class;

    /**
     * Find a language by its ISO 639-1 language code
     *
     * @param string $languageCode ISO 639-1 code (e.g. 'de', 'en', 'fr')
     * @return Language|null
     */
    public function findByLanguageCode(string $languageCode): ?Language
    {
        $repoClass = $this->getEntityRepoClassInstance();
        $queryBuilder = $repoClass::createQueryBuilder();
        $baseModelAlias = $repoClass::getBaseModelAlias();
        $queryBuilder->andWhere("{$baseModelAlias}.languageCode = :languageCode");
        $queryBuilder->setParameter('languageCode', $languageCode);

        return $repoClass->find($queryBuilder);
    }

    /**
     * Imports all languages from the config file (config/app/Common/Languages.php).
     * For each language entry: if a language with the same languageCode already exists,
     * it is updated with the config values; otherwise a new Language is created.
     */
    public function importLanguagesFromConfig(): Languages
    {
        $importedLanguages = new Languages();

        $languagesConfig = Config::get('Common.Political.Languages.languages');
        if (!is_array($languagesConfig) || empty($languagesConfig)) {
            return $importedLanguages;
        }

        foreach ($languagesConfig as $languageData) {
            $languageCode = $languageData['languageCode'] ?? null;
            if ($languageCode === null) {
                continue;
            }

            $existingLanguage = $this->findByLanguageCode($languageCode);

            // name is #[Translatable] (typed ?string), config has it as array — extract English name
            $nameValue = is_array($languageData['name'] ?? null)
                ? ($languageData['name']['en'] ?? null)
                : ($languageData['name'] ?? null);

            if ($existingLanguage !== null) {
                // Update existing language with config values
                $existingLanguage->iso3Code = $languageData['iso3Code'] ?? $existingLanguage->iso3Code;
                $existingLanguage->name = $nameValue ?? $existingLanguage->name;
                $existingLanguage->nativeName = $languageData['nativeName'] ?? $existingLanguage->nativeName;
                $existingLanguage->textDirection = $languageData['textDirection'] ?? $existingLanguage->textDirection;
                $existingLanguage->scriptCode = $languageData['scriptCode'] ?? $existingLanguage->scriptCode;
                $existingLanguage->isActive = $languageData['isActive'] ?? $existingLanguage->isActive;
                $existingLanguage->displayOrder = $languageData['displayOrder'] ?? $existingLanguage->displayOrder;
                $this->applyNameTranslations($existingLanguage, $languageData['name'] ?? null);

                $updatedLanguage = $this->update($existingLanguage);
                $importedLanguages->add($updatedLanguage);
            } else {
                // Create new language from config
                $language = new Language();
                $language->languageCode = $languageCode;
                $language->iso3Code = $languageData['iso3Code'] ?? null;
                $language->name = $nameValue;
                $language->nativeName = $languageData['nativeName'] ?? null;
                $language->textDirection = $languageData['textDirection'] ?? Language::TEXT_DIRECTION_LTR;
                $language->scriptCode = $languageData['scriptCode'] ?? null;
                $language->isActive = $languageData['isActive'] ?? true;
                $language->displayOrder = $languageData['displayOrder'] ?? null;
                $this->applyNameTranslations($language, $languageData['name'] ?? null);

                $createdLanguage = $this->update($language);
                $importedLanguages->add($createdLanguage);
            }
        }

        return $importedLanguages;
    }

    /**
     * Find all active languages, optionally filtered by language codes
     *
     * @param array|null $languageCodesToFilterFor Optional array of language codes to filter by
     * @return Languages
     */
    public function findActiveLanguages(?array $languageCodesToFilterFor = null): Languages
    {
        $repoClass = $this->getEntitySetRepoClassInstance();
        $queryBuilder = $repoClass::createQueryBuilder();
        $baseModelAlias = $repoClass::getBaseModelAlias();

        $queryBuilder->andWhere("{$baseModelAlias}.isActive = :isActive");
        $queryBuilder->setParameter('isActive', true);

        if ($languageCodesToFilterFor !== null && !empty($languageCodesToFilterFor)) {
            $queryBuilder->andWhere("{$baseModelAlias}.languageCode IN (:languageCodes)");
            $queryBuilder->setParameter('languageCodes', $languageCodesToFilterFor);
        }

        $queryBuilder->orderBy("{$baseModelAlias}.displayOrder", 'ASC');

        return $repoClass->find($queryBuilder);
    }

    /**
     * Sets translations for the name property from a config name array.
     *
     * @param Language $language
     * @param array<string, string>|string|null $nameData Config value — array of langCode => name, or plain string
     */
    protected function applyNameTranslations(Language $language, array|string|null $nameData): void
    {
        if (!is_array($nameData)) {
            return;
        }
        foreach ($nameData as $langCode => $translatedName) {
            $language->setTranslationForProperty('name', $translatedName, $langCode);
        }
    }

    /**
     * Find the default locale for a given language
     *
     * @param Language $language
     * @return Locale|null
     */
    public function findDefaultLocaleForLanguage(Language $language): ?Locale
    {
        $localesService = Locales::getService();
        return $localesService->findDefaultLocaleForLanguage($language);
    }
}
