<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Entities\Languages;

use DDD\Domain\Common\Entities\Locales\Locale;
use DDD\Domain\Common\Entities\Roles\Role;
use DDD\Domain\Common\Repo\DB\Languages\DBLanguage;
use DDD\Domain\Common\Services\LanguagesService;
use DDD\Domain\Base\Entities\Attributes\NoRecursiveUpdate;
use DDD\Domain\Base\Entities\Attributes\RolesRequiredForUpdate;
use DDD\Domain\Base\Entities\Entity;
use DDD\Domain\Base\Entities\LazyLoad\LazyLoadRepo;
use DDD\Domain\Base\Entities\QueryOptions\QueryOptionsTrait;
use DDD\Domain\Base\Entities\Translatable\Translatable;
use DDD\Domain\Base\Entities\Translatable\TranslatableTrait;
use DDD\Domain\Base\Repo\DB\Database\DatabaseIndex;
use DDD\Infrastructure\Validation\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\PositiveOrZero;

/**
 * Language entity represents a spoken/written language (e.g., German, English, French).
 * Used as reference data across the platform for translations, locale configuration,
 * and content language support.
 *
 * @method static LanguagesService getService()
 * @method static DBLanguage getRepoClassInstance(string $repoType = null)
 */
#[LazyLoadRepo(LazyLoadRepo::DB, DBLanguage::class)]
#[RolesRequiredForUpdate(Role::ADMIN)]
#[NoRecursiveUpdate]
class Language extends Entity
{
    use TranslatableTrait, QueryOptionsTrait;

    /** @var string LTR text direction (left-to-right) */
    public const string TEXT_DIRECTION_LTR = 'LTR';

    /** @var string RTL text direction (right-to-left) */
    public const string TEXT_DIRECTION_RTL = 'RTL';

    /** @var string Language supports only informal writing style */
    public const string WRITING_STYLE_INFORMAL = 'INFORMAL';

    /** @var string Language supports only formal writing style */
    public const string WRITING_STYLE_FORMAL = 'FORMAL';

    /** @var string Language supports both formal and informal writing styles */
    public const string WRITING_STYLE_FORMAL_AND_INFORMAL = 'FORMAL_AND_INFORMAL';

    /**
     * @var string|null ISO 639-1 two-letter language code
     * @example de, en, fr, nl, es
     */
    #[Length(max: 5)]
    #[DatabaseIndex(indexType: DatabaseIndex::TYPE_UNIQUE)]
    public ?string $languageCode;

    /**
     * @var string|null ISO 639-3 three-letter language code
     * @example deu, eng, fra, nld, spa
     */
    #[Length(max: 10)]
    #[DatabaseIndex(indexType: DatabaseIndex::TYPE_UNIQUE)]
    public ?string $iso3Code = null;

    /**
     * @var string|null Language name (multilingual, e.g. "German" in English, "Deutsch" in German)
     */
    #[Translatable]
    public ?string $name;

    /**
     * @var string|null The name of the language in its own language (e.g., "Deutsch", "Français", "Español")
     */
    #[Length(max: 100)]
    public ?string $nativeName = null;

    /**
     * @var string Text direction for rendering
     */
    #[Choice(choices: [self::TEXT_DIRECTION_LTR, self::TEXT_DIRECTION_RTL])]
    #[Length(max: 3)]
    public string $textDirection = self::TEXT_DIRECTION_LTR;

    /**
     * @var string|null ISO 15924 script code (e.g., "Latn" for Latin, "Cyrl" for Cyrillic, "Arab" for Arabic)
     */
    #[Length(max: 10)]
    public ?string $scriptCode = null;

    /** @var bool Whether this language is active/available on the platform */
    public bool $isActive = true;

    /** @var int|null Display order for sorting; null means unordered / appended last */
    #[PositiveOrZero]
    public ?int $displayOrder = null;

    /**
     * @var string Which writing styles this language supports for app translations.
     * Controls whether formal, informal, or both variants are generated.
     */
    #[Choice(choices: [self::WRITING_STYLE_INFORMAL, self::WRITING_STYLE_FORMAL, self::WRITING_STYLE_FORMAL_AND_INFORMAL])]
    #[Length(max: 30)]
    public string $supportedWritingStyles = self::WRITING_STYLE_INFORMAL;

    public function uniqueKey(): string
    {
        return self::uniqueKeyStatic($this->languageCode ?? ($this->id ?? spl_object_id($this)));
    }

    /**
     * Find the default Locale
     * @return Locale|null
     */
    public function getDefaultLocale(): ?Locale
    {
        return self::getService()->findDefaultLocaleForLanguage($this);
    }
}
