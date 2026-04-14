<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Entities\Locales;

use DDD\Domain\Common\Entities\Languages\Language;
use DDD\Domain\Common\Repo\DB\Locales\DBLocales;
use DDD\Domain\Common\Services\Languages\LocalesService;
use DDD\Domain\Base\Entities\EntitySet;
use DDD\Domain\Base\Entities\LazyLoad\LazyLoadRepo;
use DDD\Domain\Base\Entities\QueryOptions\QueryOptionsTrait;

/**
 * Collection of Locale entities
 *
 * @property Locale[] $elements
 * @method Locale getByUniqueKey(string $uniqueKey)
 * @method Locale[] getElements()
 * @method Locale first()
 * @method static LocalesService getService()
 */
#[LazyLoadRepo(LazyLoadRepo::DB, DBLocales::class)]
class Locales extends EntitySet
{
    use QueryOptionsTrait;

    public const string SERVICE_NAME = LocalesService::class;

    /**
     * Returns the default locale for a given Language
     * @param string $languageCode
     * @return Locale|null
     */
    public function getDefaultLocaleForLanguage(Language $language): ?Locale
    {
        return $this->getDefaultLocaleForLanguageCode($language->languageCode);
    }

    /**
     * Returns the default locale for a given languageCode
     * @param string $languageCode
     * @return Locale|null
     */
    public function getDefaultLocaleForLanguageCode(string $languageCode): ?Locale
    {
        foreach ($this->getElements() as $locale) {
            if ($locale->isDefaultLocaleForLanguage && $locale->languageCode == $languageCode) {
                return $locale;
            }
        }
        return null;
    }

    /**
     * @return string|null Returns the language from the first $locale with isDefaultLocaleForLanguage found
     */
    public function getDefaultLanguage(): ?string
    {
        foreach ($this->getElements() as $locale) {
            if ($locale->isDefaultLocaleForLanguage) {
                return $locale->languageCode;
            }
        }
        return null;
    }

    /**
     * @return string Returns comma separated string including all locales, e.g. de-de, de-at etc.
     */
    public function getLocalesAsCommaSeparatedString(): string
    {
        $return = '';
        foreach ($this->getElements() as $locale) {
            $return .= ($return ? ', ' : '') . $locale->languageCode . '-' . $locale->countryShortCode;
        }
        return $return;
    }

    public function getLanguageCodes(): array
    {
        $languageCodes = [];
        foreach ($this->getElements() as $locale) {
            $languageCodes[] = $locale->languageCode;
        }
        return $languageCodes;
    }
}
