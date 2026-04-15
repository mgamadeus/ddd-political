<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Entities\Locales;

use DDD\Domain\Common\Entities\Languages\Language;
use DDD\Domain\Common\Entities\PoliticalEntities\Countries\Country;
use DDD\Domain\Common\Entities\Roles\Role;
use DDD\Domain\Common\Repo\DB\Locales\DBLocale;
use DDD\Domain\Common\Services\Languages\LocalesService;
use DateTime;
use DDD\Domain\Base\Entities\Attributes\RolesRequiredForUpdate;
use DDD\Domain\Base\Entities\Entity;
use DDD\Domain\Base\Entities\LazyLoad\LazyLoad;
use DDD\Domain\Base\Entities\LazyLoad\LazyLoadRepo;
use DDD\Domain\Base\Entities\QueryOptions\QueryOptionsTrait;
use DDD\Domain\Base\Entities\Translatable\Translatable;
use DDD\Domain\Base\Entities\Translatable\TranslatableTrait;
use DDD\Domain\Base\Repo\DB\Database\DatabaseIndex;
use DDD\Infrastructure\Base\DateTime\Date;
use DDD\Infrastructure\Libs\Config;

/**
 * @property Locales|null $parent
 * @method Locales|null getParent()
 * @method static LocalesService getService()
 * @method static DBLocale getRepoClassInstance(string $repoType = null)
 */
#[LazyLoadRepo(LazyLoadRepo::DB, DBLocale::class)]
#[RolesRequiredForUpdate(Role::ADMIN)]
#[DatabaseIndex(DatabaseIndex::TYPE_UNIQUE, ['languageId', 'countryId'])]
class Locale extends Entity
{
    use TranslatableTrait, QueryOptionsTrait;

    /** @var string|null Human-readable locale name (e.g., "Schweizerdeutsch", "Deutsch (Deutschland)", "English (US)") */
    #[Translatable]
    public ?string $name = null;

    /** @var string|null The language code of the locale (e.g., 'de', 'en') */
    public ?string $languageCode;

    /** @var int|null The language entity ID */
    public ?int $languageId = null;

    /** @var Language|null The language entity */
    #[LazyLoad(addAsParent: true)]
    public ?Language $language;

    /** @var int|null The country ID of the locale */
    public ?int $countryId = null;

    /** @var Country|null The country of the locale */
    #[LazyLoad(addAsParent: true)]
    public ?Country $country;

    /** @var string|null The shortCode of the Locale's Country */
    public ?string $countryShortCode;

    /** @var bool If true, this is the default locale for Canguage */
    public ?bool $isDefaultLocaleForLanguage = false;

    /** @var bool If true, this is the default locale for Country */
    public ?bool $isDefaultLocaleForCountry = false;

    /** @var bool Whether this locale is active and available for selection */
    public bool $isActive = true;

    /**
     * Returns a locale from a string like de-de
     * @param string $localeString
     * @return Locale|null
     */
    public static function fromString(string $localeString): ?Locale
    {
        $separator = '-';
        if (strpos($localeString, '_') !== false) {
            $separator = '_';
        }
        [$language, $countryShortCode] = explode($separator, $localeString);
        $language = strtolower($language);
        $countryShortCode = strtolower($countryShortCode);
        return self::getLocaleForInput($language, $countryShortCode);
    }

    public static function getLocaleForInput(
        string $language = null,
        string $countryShortCode = null,
        Locale $locale = null
    ): ?Locale {
        if ($locale) {
            return $locale;
        } elseif ($language && $countryShortCode) {
            $newLocale = new Locale();
            $newLocale->languageCode = $language;
            $newLocale->countryShortCode = $countryShortCode;
            return $newLocale;
        } elseif ($language) {
            if ($countryShortCode = Config::get('Common.Political.Locales.defaultCountryCodesForLanguage.' . $language)) {
                $newLocale = new Locale();
                $newLocale->languageCode = $language;
                $newLocale->countryShortCode = $countryShortCode;
                return $newLocale;
            }
        }
        return null;
    }

    public function setPropertiesFromObject(object &$object, $throwErrors = true, bool $rootCall = true, bool $sanitizeInput = false): void
    {
        parent::setPropertiesFromObject($object, $throwErrors, $rootCall, $sanitizeInput);
        if (isset($this->languageCode) && !isset($this->countryShortCode)) {
            if ($countryShortCode = Config::get('Common.Political.Locales.defaultCountryCodesForLanguage.' . $this->languageCode)) {
                $this->countryShortCode = $countryShortCode;
            }
        }
    }

    public function uniqueKey(): string
    {
        $key = '';
        if (isset($this->languageId)) {
            $key .= $this->languageId;
        }
        if (isset($this->countryId)) {
            $key .= '_' . $this->countryId;
        }
        if (isset($this->languageCode)) {
            $key .= '_' . $this->languageCode;
        }
        if (isset($this->countryShortCode)) {
            $key .= '_' . $this->countryShortCode;
        }
        return self::uniqueKeyStatic($key);
    }

    public function __toString(): string
    {
        return (isset($this->languageCode) ? $this->languageCode : '') . '-' . (isset($this->countryShortCode) ? $this->countryShortCode : '');
    }

    public function formatDateOrDateTime(DateTime $dateOrDateTime): string
    {
        $timeConfig = Config::get('Common.Political.Locales.dateTimeFormats')[$this . ''] ?? Config::get('Common.Political.Locales.dateTimeFormats.default');
        if ($dateOrDateTime instanceof Date) {
            return $dateOrDateTime->format($timeConfig['date']);
        }
        return $dateOrDateTime->format($timeConfig['date'] . ' ' . $timeConfig['time']);
    }
}
