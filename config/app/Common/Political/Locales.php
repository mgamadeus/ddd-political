<?php

/**
 * Locale seed data for import into the Locales table.
 *
 * Each entry is keyed by "{languageCode}-{countryShortCode}" and maps
 * directly to Locale entity properties. Only languages that are
 * officially spoken or widely relevant within each country are included.
 *
 * Covers all 236 countries from Countries.php × 46 languages from Languages.php.
 * Total: ~277 locale entries.
 *
 * Flags:
 *   isDefaultLocaleForLanguage – exactly one locale per language (the "canonical" country)
 *   isDefaultLocaleForCountry  – exactly one locale per country (the primary language)
 *
 * @see \DDD\Domain\Common\Entities\Locales\Locale
 * @see \DDD\Domain\Common\Entities\Languages\Language
 * @see \DDD\Domain\Common\Entities\PoliticalEntities\Countries\Country
 */
return [

    // ─── Default country for each language (used by Locale::getLocaleForInput) ──
    'defaultCountryCodesForLanguage' => [
        // Tier 1
        'en' => 'us',
        'es' => 'es',
        'fr' => 'fr',
        'ar' => 'sa',
        'pt' => 'pt',
        'de' => 'de',
        'ru' => 'ru',
        // Tier 2
        'it' => 'it',
        'nl' => 'nl',
        'pl' => 'pl',
        'tr' => 'tr',
        'fa' => 'ir',
        'uk' => 'ua',
        'ro' => 'ro',
        'el' => 'gr',
        'he' => 'il',
        'sv' => 'se',
        'hu' => 'hu',
        'cs' => 'cz',
        'da' => 'dk',
        'fi' => 'fi',
        'nb' => 'no',
        'bg' => 'bg',
        'sr' => 'rs',
        'hr' => 'hr',
        'sk' => 'sk',
        // Tier 3
        'lt' => 'lt',
        'sl' => 'si',
        'lv' => 'lv',
        'et' => 'ee',
        'sq' => 'al',
        'mk' => 'mk',
        'bs' => 'ba',
        'be' => 'by',
        'is' => 'is',
        'ca' => 'ad',
        'ga' => 'ie',
        'cy' => 'gb',
        'mt' => 'mt',
        'lb' => 'lu',
        'ku' => 'iq',
        // Tier 4
        'gn' => 'py',
        'qu' => 'pe',
        'ay' => 'bo',
        // Tier 5 – KYC additional languages
        'az' => 'az',
        'hi' => 'in',
        'hy' => 'am',
        'id' => 'id',
        'ka' => 'ge',
        'kk' => 'kz',
        'ko' => 'kr',
        'ky' => 'kg',
        'lo' => 'la',
        'mn' => 'mn',
        'ms' => 'my',
        'my' => 'mm',
        'ne' => 'np',
        'so' => 'so',
        'sw' => 'tz',
        'tg' => 'tj',
        'th' => 'th',
        'tk' => 'tm',
        'uz' => 'uz',
        'vi' => 'vn',
        'zh' => 'cn',
        'ja' => 'jp',
        'si' => 'lk',
        'dv' => 'mv',
        'dz' => 'bt',
    ],

    // ─── Date/time formats by locale ────────────────────────────────────────────
    'dateTimeFormats' => [
        'default' => [
            'date' => 'm/d/Y',
            'time' => 'g:i A',
        ],
        'en-us' => [
            'date' => 'm/d/Y',
            'time' => 'g:i A',
        ],
        'en-gb' => [
            'date' => 'd/m/Y',
            'time' => 'H:i',
        ],
        'de-de' => [
            'date' => 'd.m.Y',
            'time' => 'H:i',
        ],
        'de-at' => [
            'date' => 'd.m.Y',
            'time' => 'H:i',
        ],
        'de-ch' => [
            'date' => 'd.m.Y',
            'time' => 'H:i',
        ],
        'fr-fr' => [
            'date' => 'd/m/Y',
            'time' => 'H:i',
        ],
        'es-es' => [
            'date' => 'd/m/Y',
            'time' => 'H:i',
        ],
        'it-it' => [
            'date' => 'd/m/Y',
            'time' => 'H:i',
        ],
        'nl-nl' => [
            'date' => 'd-m-Y',
            'time' => 'H:i',
        ],
        'pt-pt' => [
            'date' => 'd/m/Y',
            'time' => 'H:i',
        ],
        'pt-br' => [
            'date' => 'd/m/Y',
            'time' => 'H:i',
        ],
        'ru-ru' => [
            'date' => 'd.m.Y',
            'time' => 'H:i',
        ],
        'ar-sa' => [
            'date' => 'd/m/Y',
            'time' => 'g:i A',
        ],
        'ja-jp' => [
            'date' => 'Y/m/d',
            'time' => 'H:i',
        ],
        'sv-se' => [
            'date' => 'Y-m-d',
            'time' => 'H:i',
        ],
        'da-dk' => [
            'date' => 'd.m.Y',
            'time' => 'H:i',
        ],
        'nb-no' => [
            'date' => 'd.m.Y',
            'time' => 'H:i',
        ],
        'fi-fi' => [
            'date' => 'd.m.Y',
            'time' => 'H:i',
        ],
        'pl-pl' => [
            'date' => 'd.m.Y',
            'time' => 'H:i',
        ],
        'tr-tr' => [
            'date' => 'd.m.Y',
            'time' => 'H:i',
        ],
        'el-gr' => [
            'date' => 'd/m/Y',
            'time' => 'H:i',
        ],
        'he-il' => [
            'date' => 'd.m.Y',
            'time' => 'H:i',
        ],

        'hi-in' => [
            'date' => 'd/m/Y',
            'time' => 'g:i A',
        ],
        'id-id' => [
            'date' => 'd/m/Y',
            'time' => 'H:i',
        ],
        'ko-kr' => [
            'date' => 'Y. m. d.',
            'time' => 'H:i',
        ],
        'ms-my' => [
            'date' => 'd/m/Y',
            'time' => 'g:i A',
        ],
        'ne-np' => [
            'date' => 'Y/m/d',
            'time' => 'g:i A',
        ],
        'sw-tz' => [
            'date' => 'd/m/Y',
            'time' => 'H:i',
        ],
        'th-th' => [
            'date' => 'd/m/Y',
            'time' => 'H:i',
        ],
        'vi-vn' => [
            'date' => 'd/m/Y',
            'time' => 'H:i',
        ],
        'zh-cn' => [
            'date' => 'Y/m/d',
            'time' => 'H:i',
        ],
    ],

    // ─── Locale entries ─────────────────────────────────────────────────────────
    'locales' => [

        // ══════════════════════════════════════════════════════════════════
        // GERMAN (de)
        // ══════════════════════════════════════════════════════════════════
        'de-de' => [
            'name' => 'Deutsch (Deutschland)',
            'languageCode' => 'de',
            'countryShortCode' => 'de',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'de-at' => [
            'name' => 'Österreichisches Deutsch',
            'languageCode' => 'de',
            'countryShortCode' => 'at',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'de-ch' => [
            'name' => 'Schweizerdeutsch',
            'languageCode' => 'de',
            'countryShortCode' => 'ch',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'de-li' => [
            'name' => 'Deutsch (Liechtenstein)',
            'languageCode' => 'de',
            'countryShortCode' => 'li',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'de-lu' => [
            'name' => 'Deutsch (Luxemburg)',
            'languageCode' => 'de',
            'countryShortCode' => 'lu',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => false,
        ],
        'de-be' => [
            'name' => 'Deutsch (Belgien)',
            'languageCode' => 'de',
            'countryShortCode' => 'be',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => false,
        ],

        // ══════════════════════════════════════════════════════════════════
        // ENGLISH (en)
        // ══════════════════════════════════════════════════════════════════
        'en-us' => [
            'name' => 'English (US)',
            'languageCode' => 'en',
            'countryShortCode' => 'us',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-gb' => [
            'name' => 'English (UK)',
            'languageCode' => 'en',
            'countryShortCode' => 'gb',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-ie' => [
            'name' => 'English (Ireland)',
            'languageCode' => 'en',
            'countryShortCode' => 'ie',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-au' => [
            'name' => 'English (Australia)',
            'languageCode' => 'en',
            'countryShortCode' => 'au',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-nz' => [
            'name' => 'English (New Zealand)',
            'languageCode' => 'en',
            'countryShortCode' => 'nz',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-ca' => [
            'name' => 'English (Canada)',
            'languageCode' => 'en',
            'countryShortCode' => 'ca',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-sg' => [
            'name' => 'English (Singapore)',
            'languageCode' => 'en',
            'countryShortCode' => 'sg',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-hk' => [
            'name' => 'English (Hong Kong)',
            'languageCode' => 'en',
            'countryShortCode' => 'hk',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-ph' => [
            'name' => 'English (Philippines)',
            'languageCode' => 'en',
            'countryShortCode' => 'ph',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-in' => [
            'name' => 'English (India)',
            'languageCode' => 'en',
            'countryShortCode' => 'in',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-pk' => [
            'name' => 'English (Pakistan)',
            'languageCode' => 'en',
            'countryShortCode' => 'pk',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-bd' => [
            'name' => 'English (Bangladesh)',
            'languageCode' => 'en',
            'countryShortCode' => 'bd',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-ng' => [
            'name' => 'English (Nigeria)',
            'languageCode' => 'en',
            'countryShortCode' => 'ng',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-gh' => [
            'name' => 'English (Ghana)',
            'languageCode' => 'en',
            'countryShortCode' => 'gh',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-ke' => [
            'name' => 'English (Kenya)',
            'languageCode' => 'en',
            'countryShortCode' => 'ke',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-za' => [
            'name' => 'English (South Africa)',
            'languageCode' => 'en',
            'countryShortCode' => 'za',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-jm' => [
            'name' => 'English (Jamaica)',
            'languageCode' => 'en',
            'countryShortCode' => 'jm',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-tt' => [
            'name' => 'English (Trinidad and Tobago)',
            'languageCode' => 'en',
            'countryShortCode' => 'tt',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-bs' => [
            'name' => 'English (Bahamas)',
            'languageCode' => 'en',
            'countryShortCode' => 'bs',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-bb' => [
            'name' => 'English (Barbados)',
            'languageCode' => 'en',
            'countryShortCode' => 'bb',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-ag' => [
            'name' => 'English (Antigua and Barbuda)',
            'languageCode' => 'en',
            'countryShortCode' => 'ag',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-dm' => [
            'name' => 'English (Dominica)',
            'languageCode' => 'en',
            'countryShortCode' => 'dm',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-gd' => [
            'name' => 'English (Grenada)',
            'languageCode' => 'en',
            'countryShortCode' => 'gd',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-kn' => [
            'name' => 'English (St. Kitts and Nevis)',
            'languageCode' => 'en',
            'countryShortCode' => 'kn',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-lc' => [
            'name' => 'English (St. Lucia)',
            'languageCode' => 'en',
            'countryShortCode' => 'lc',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-vc' => [
            'name' => 'English (St. Vincent)',
            'languageCode' => 'en',
            'countryShortCode' => 'vc',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-gy' => [
            'name' => 'English (Guyana)',
            'languageCode' => 'en',
            'countryShortCode' => 'gy',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-bz' => [
            'name' => 'English (Belize)',
            'languageCode' => 'en',
            'countryShortCode' => 'bz',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-mt' => [
            'name' => 'English (Malta)',
            'languageCode' => 'en',
            'countryShortCode' => 'mt',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => false,
        ],
        'en-ae' => [
            'name' => 'English (UAE)',
            'languageCode' => 'en',
            'countryShortCode' => 'ae',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => false,
        ],
        // Fallback locales for countries without native language in Languages config
        'en-jp' => [
            'name' => 'English (Japan)',
            'languageCode' => 'en',
            'countryShortCode' => 'jp',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-kr' => [
            'name' => 'English (South Korea)',
            'languageCode' => 'en',
            'countryShortCode' => 'kr',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-tw' => [
            'name' => 'English (Taiwan)',
            'languageCode' => 'en',
            'countryShortCode' => 'tw',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-th' => [
            'name' => 'English (Thailand)',
            'languageCode' => 'en',
            'countryShortCode' => 'th',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-vn' => [
            'name' => 'English (Vietnam)',
            'languageCode' => 'en',
            'countryShortCode' => 'vn',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-id' => [
            'name' => 'English (Indonesia)',
            'languageCode' => 'en',
            'countryShortCode' => 'id',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-my' => [
            'name' => 'English (Malaysia)',
            'languageCode' => 'en',
            'countryShortCode' => 'my',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-kh' => [
            'name' => 'English (Cambodia)',
            'languageCode' => 'en',
            'countryShortCode' => 'kh',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],

        // ══════════════════════════════════════════════════════════════════
        // SPANISH (es)
        // ══════════════════════════════════════════════════════════════════
        'es-es' => [
            'name' => 'Español (España)',
            'languageCode' => 'es',
            'countryShortCode' => 'es',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'es-mx' => [
            'name' => 'Español mexicano',
            'languageCode' => 'es',
            'countryShortCode' => 'mx',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'es-co' => [
            'name' => 'Español (Colombia)',
            'languageCode' => 'es',
            'countryShortCode' => 'co',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'es-ar' => [
            'name' => 'Español rioplatense',
            'languageCode' => 'es',
            'countryShortCode' => 'ar',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'es-pe' => [
            'name' => 'Español (Perú)',
            'languageCode' => 'es',
            'countryShortCode' => 'pe',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'es-cl' => [
            'name' => 'Español (Chile)',
            'languageCode' => 'es',
            'countryShortCode' => 'cl',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'es-ve' => [
            'name' => 'Español (Venezuela)',
            'languageCode' => 'es',
            'countryShortCode' => 've',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'es-ec' => [
            'name' => 'Español (Ecuador)',
            'languageCode' => 'es',
            'countryShortCode' => 'ec',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'es-bo' => [
            'name' => 'Español (Bolivia)',
            'languageCode' => 'es',
            'countryShortCode' => 'bo',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'es-py' => [
            'name' => 'Español (Paraguay)',
            'languageCode' => 'es',
            'countryShortCode' => 'py',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'es-uy' => [
            'name' => 'Español (Uruguay)',
            'languageCode' => 'es',
            'countryShortCode' => 'uy',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'es-gt' => [
            'name' => 'Español (Guatemala)',
            'languageCode' => 'es',
            'countryShortCode' => 'gt',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'es-sv' => [
            'name' => 'Español (El Salvador)',
            'languageCode' => 'es',
            'countryShortCode' => 'sv',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'es-hn' => [
            'name' => 'Español (Honduras)',
            'languageCode' => 'es',
            'countryShortCode' => 'hn',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'es-ni' => [
            'name' => 'Español (Nicaragua)',
            'languageCode' => 'es',
            'countryShortCode' => 'ni',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'es-cr' => [
            'name' => 'Español (Costa Rica)',
            'languageCode' => 'es',
            'countryShortCode' => 'cr',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'es-pa' => [
            'name' => 'Español (Panamá)',
            'languageCode' => 'es',
            'countryShortCode' => 'pa',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'es-cu' => [
            'name' => 'Español (Cuba)',
            'languageCode' => 'es',
            'countryShortCode' => 'cu',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'es-do' => [
            'name' => 'Español (República Dominicana)',
            'languageCode' => 'es',
            'countryShortCode' => 'do',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'es-us' => [
            'name' => 'Español (Estados Unidos)',
            'languageCode' => 'es',
            'countryShortCode' => 'us',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => false,
        ],
        'es-bz' => [
            'name' => 'Español (Belice)',
            'languageCode' => 'es',
            'countryShortCode' => 'bz',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => false,
        ],

        // ══════════════════════════════════════════════════════════════════
        // FRENCH (fr)
        // ══════════════════════════════════════════════════════════════════
        'fr-fr' => [
            'name' => 'Français (France)',
            'languageCode' => 'fr',
            'countryShortCode' => 'fr',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-be' => [
            'name' => 'Français (Belgique)',
            'languageCode' => 'fr',
            'countryShortCode' => 'be',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => false,
        ],
        'fr-ch' => [
            'name' => 'Français (Suisse)',
            'languageCode' => 'fr',
            'countryShortCode' => 'ch',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => false,
        ],
        'fr-lu' => [
            'name' => 'Français (Luxembourg)',
            'languageCode' => 'fr',
            'countryShortCode' => 'lu',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => false,
        ],
        'fr-ca' => [
            'name' => 'Français canadien',
            'languageCode' => 'fr',
            'countryShortCode' => 'ca',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => false,
        ],
        'fr-mc' => [
            'name' => 'Français (Monaco)',
            'languageCode' => 'fr',
            'countryShortCode' => 'mc',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-ht' => [
            'name' => 'Français (Haïti)',
            'languageCode' => 'fr',
            'countryShortCode' => 'ht',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-gf' => [
            'name' => 'Français (Guyane)',
            'languageCode' => 'fr',
            'countryShortCode' => 'gf',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-gp' => [
            'name' => 'Français (Guadeloupe)',
            'languageCode' => 'fr',
            'countryShortCode' => 'gp',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-mq' => [
            'name' => 'Français (Martinique)',
            'languageCode' => 'fr',
            'countryShortCode' => 'mq',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-re' => [
            'name' => 'Français (Réunion)',
            'languageCode' => 'fr',
            'countryShortCode' => 're',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-yt' => [
            'name' => 'Français (Mayotte)',
            'languageCode' => 'fr',
            'countryShortCode' => 'yt',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-pf' => [
            'name' => 'Français (Polynésie)',
            'languageCode' => 'fr',
            'countryShortCode' => 'pf',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-dz' => [
            'name' => 'Français (Algérie)',
            'languageCode' => 'fr',
            'countryShortCode' => 'dz',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => false,
        ],
        'fr-ma' => [
            'name' => 'Français (Maroc)',
            'languageCode' => 'fr',
            'countryShortCode' => 'ma',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => false,
        ],
        'fr-lb' => [
            'name' => 'Français (Liban)',
            'languageCode' => 'fr',
            'countryShortCode' => 'lb',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => false,
        ],

        // ══════════════════════════════════════════════════════════════════
        // ARABIC (ar)
        // ══════════════════════════════════════════════════════════════════
        'ar-sa' => [
            'name' => 'العربية (السعودية)',
            'languageCode' => 'ar',
            'countryShortCode' => 'sa',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'ar-ae' => [
            'name' => 'العربية (الإمارات)',
            'languageCode' => 'ar',
            'countryShortCode' => 'ae',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'ar-kw' => [
            'name' => 'العربية (الكويت)',
            'languageCode' => 'ar',
            'countryShortCode' => 'kw',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'ar-bh' => [
            'name' => 'العربية (البحرين)',
            'languageCode' => 'ar',
            'countryShortCode' => 'bh',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'ar-qa' => [
            'name' => 'العربية (قطر)',
            'languageCode' => 'ar',
            'countryShortCode' => 'qa',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'ar-om' => [
            'name' => 'العربية (عُمان)',
            'languageCode' => 'ar',
            'countryShortCode' => 'om',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'ar-jo' => [
            'name' => 'العربية (الأردن)',
            'languageCode' => 'ar',
            'countryShortCode' => 'jo',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'ar-lb' => [
            'name' => 'العربية (لبنان)',
            'languageCode' => 'ar',
            'countryShortCode' => 'lb',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'ar-iq' => [
            'name' => 'العربية (العراق)',
            'languageCode' => 'ar',
            'countryShortCode' => 'iq',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'ar-sy' => [
            'name' => 'العربية (سوريا)',
            'languageCode' => 'ar',
            'countryShortCode' => 'sy',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'ar-ye' => [
            'name' => 'العربية (اليمن)',
            'languageCode' => 'ar',
            'countryShortCode' => 'ye',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'ar-ps' => [
            'name' => 'العربية (فلسطين)',
            'languageCode' => 'ar',
            'countryShortCode' => 'ps',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'ar-eg' => [
            'name' => 'العربية (مصر)',
            'languageCode' => 'ar',
            'countryShortCode' => 'eg',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'ar-dz' => [
            'name' => 'العربية (الجزائر)',
            'languageCode' => 'ar',
            'countryShortCode' => 'dz',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'ar-ma' => [
            'name' => 'العربية (المغرب)',
            'languageCode' => 'ar',
            'countryShortCode' => 'ma',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'ar-il' => [
            'name' => 'العربية (إسرائيل)',
            'languageCode' => 'ar',
            'countryShortCode' => 'il',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => false,
        ],

        // ══════════════════════════════════════════════════════════════════
        // PORTUGUESE (pt)
        // ══════════════════════════════════════════════════════════════════
        'pt-pt' => [
            'name' => 'Português (Portugal)',
            'languageCode' => 'pt',
            'countryShortCode' => 'pt',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'pt-br' => [
            'name' => 'Português brasileiro',
            'languageCode' => 'pt',
            'countryShortCode' => 'br',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],

        // ══════════════════════════════════════════════════════════════════
        // RUSSIAN (ru)
        // ══════════════════════════════════════════════════════════════════
        'ru-ru' => [
            'name' => 'Русский (Россия)',
            'languageCode' => 'ru',
            'countryShortCode' => 'ru',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'ru-by' => [
            'name' => 'Русский (Беларусь)',
            'languageCode' => 'ru',
            'countryShortCode' => 'by',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => false,
        ],

        // ══════════════════════════════════════════════════════════════════
        // ITALIAN (it)
        // ══════════════════════════════════════════════════════════════════
        'it-it' => [
            'name' => 'Italiano (Italia)',
            'languageCode' => 'it',
            'countryShortCode' => 'it',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'it-ch' => [
            'name' => 'Italiano (Svizzera)',
            'languageCode' => 'it',
            'countryShortCode' => 'ch',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => false,
        ],
        'it-sm' => [
            'name' => 'Italiano (San Marino)',
            'languageCode' => 'it',
            'countryShortCode' => 'sm',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],

        // ══════════════════════════════════════════════════════════════════
        // DUTCH (nl)
        // ══════════════════════════════════════════════════════════════════
        'nl-nl' => [
            'name' => 'Nederlands (Nederland)',
            'languageCode' => 'nl',
            'countryShortCode' => 'nl',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'nl-be' => [
            'name' => 'Nederlands (België)',
            'languageCode' => 'nl',
            'countryShortCode' => 'be',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'nl-sr' => [
            'name' => 'Nederlands (Suriname)',
            'languageCode' => 'nl',
            'countryShortCode' => 'sr',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],

        // ══════════════════════════════════════════════════════════════════
        // POLISH (pl)
        // ══════════════════════════════════════════════════════════════════
        'pl-pl' => [
            'name' => 'Polski',
            'languageCode' => 'pl',
            'countryShortCode' => 'pl',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],

        // ══════════════════════════════════════════════════════════════════
        // TURKISH (tr)
        // ══════════════════════════════════════════════════════════════════
        'tr-tr' => [
            'name' => 'Türkçe (Türkiye)',
            'languageCode' => 'tr',
            'countryShortCode' => 'tr',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'tr-cy' => [
            'name' => 'Türkçe (Kıbrıs)',
            'languageCode' => 'tr',
            'countryShortCode' => 'cy',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => false,
        ],

        // ══════════════════════════════════════════════════════════════════
        // PERSIAN (fa)
        // ══════════════════════════════════════════════════════════════════
        'fa-ir' => [
            'name' => 'فارسی (ایران)',
            'languageCode' => 'fa',
            'countryShortCode' => 'ir',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],

        // ══════════════════════════════════════════════════════════════════
        // UKRAINIAN (uk)
        // ══════════════════════════════════════════════════════════════════
        'uk-ua' => [
            'name' => 'Українська',
            'languageCode' => 'uk',
            'countryShortCode' => 'ua',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],

        // ══════════════════════════════════════════════════════════════════
        // ROMANIAN (ro)
        // ══════════════════════════════════════════════════════════════════
        'ro-ro' => [
            'name' => 'Română (România)',
            'languageCode' => 'ro',
            'countryShortCode' => 'ro',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'ro-md' => [
            'name' => 'Română (Moldova)',
            'languageCode' => 'ro',
            'countryShortCode' => 'md',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],

        // ══════════════════════════════════════════════════════════════════
        // GREEK (el)
        // ══════════════════════════════════════════════════════════════════
        'el-gr' => [
            'name' => 'Ελληνικά (Ελλάδα)',
            'languageCode' => 'el',
            'countryShortCode' => 'gr',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'el-cy' => [
            'name' => 'Ελληνικά (Κύπρος)',
            'languageCode' => 'el',
            'countryShortCode' => 'cy',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],

        // ══════════════════════════════════════════════════════════════════
        // HEBREW (he)
        // ══════════════════════════════════════════════════════════════════
        'he-il' => [
            'name' => 'עברית',
            'languageCode' => 'he',
            'countryShortCode' => 'il',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],

        // ══════════════════════════════════════════════════════════════════
        // SWEDISH (sv)
        // ══════════════════════════════════════════════════════════════════
        'sv-se' => [
            'name' => 'Svenska (Sverige)',
            'languageCode' => 'sv',
            'countryShortCode' => 'se',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'sv-fi' => [
            'name' => 'Svenska (Finland)',
            'languageCode' => 'sv',
            'countryShortCode' => 'fi',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => false,
        ],

        // ══════════════════════════════════════════════════════════════════
        // HUNGARIAN (hu)
        // ══════════════════════════════════════════════════════════════════
        'hu-hu' => [
            'name' => 'Magyar',
            'languageCode' => 'hu',
            'countryShortCode' => 'hu',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],

        // ══════════════════════════════════════════════════════════════════
        // CZECH (cs)
        // ══════════════════════════════════════════════════════════════════
        'cs-cz' => [
            'name' => 'Čeština',
            'languageCode' => 'cs',
            'countryShortCode' => 'cz',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],

        // ══════════════════════════════════════════════════════════════════
        // DANISH (da)
        // ══════════════════════════════════════════════════════════════════
        'da-dk' => [
            'name' => 'Dansk',
            'languageCode' => 'da',
            'countryShortCode' => 'dk',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],

        // ══════════════════════════════════════════════════════════════════
        // FINNISH (fi)
        // ══════════════════════════════════════════════════════════════════
        'fi-fi' => [
            'name' => 'Suomi',
            'languageCode' => 'fi',
            'countryShortCode' => 'fi',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],

        // ══════════════════════════════════════════════════════════════════
        // NORWEGIAN BOKMÅL (nb)
        // ══════════════════════════════════════════════════════════════════
        'nb-no' => [
            'name' => 'Norsk bokmål',
            'languageCode' => 'nb',
            'countryShortCode' => 'no',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],

        // ══════════════════════════════════════════════════════════════════
        // BULGARIAN (bg)
        // ══════════════════════════════════════════════════════════════════
        'bg-bg' => [
            'name' => 'Български',
            'languageCode' => 'bg',
            'countryShortCode' => 'bg',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],

        // ══════════════════════════════════════════════════════════════════
        // SERBIAN (sr)
        // ══════════════════════════════════════════════════════════════════
        'sr-rs' => [
            'name' => 'Српски (Србија)',
            'languageCode' => 'sr',
            'countryShortCode' => 'rs',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'sr-ba' => [
            'name' => 'Српски (Босна)',
            'languageCode' => 'sr',
            'countryShortCode' => 'ba',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => false,
        ],
        'sr-me' => [
            'name' => 'Српски (Црна Гора)',
            'languageCode' => 'sr',
            'countryShortCode' => 'me',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],

        // ══════════════════════════════════════════════════════════════════
        // CROATIAN (hr)
        // ══════════════════════════════════════════════════════════════════
        'hr-hr' => [
            'name' => 'Hrvatski (Hrvatska)',
            'languageCode' => 'hr',
            'countryShortCode' => 'hr',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'hr-ba' => [
            'name' => 'Hrvatski (Bosna)',
            'languageCode' => 'hr',
            'countryShortCode' => 'ba',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => false,
        ],

        // ══════════════════════════════════════════════════════════════════
        // SLOVAK (sk)
        // ══════════════════════════════════════════════════════════════════
        'sk-sk' => [
            'name' => 'Slovenčina',
            'languageCode' => 'sk',
            'countryShortCode' => 'sk',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],

        // ══════════════════════════════════════════════════════════════════
        // LITHUANIAN (lt)
        // ══════════════════════════════════════════════════════════════════
        'lt-lt' => [
            'name' => 'Lietuvių',
            'languageCode' => 'lt',
            'countryShortCode' => 'lt',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],

        // ══════════════════════════════════════════════════════════════════
        // SLOVENIAN (sl)
        // ══════════════════════════════════════════════════════════════════
        'sl-si' => [
            'name' => 'Slovenščina',
            'languageCode' => 'sl',
            'countryShortCode' => 'si',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],

        // ══════════════════════════════════════════════════════════════════
        // LATVIAN (lv)
        // ══════════════════════════════════════════════════════════════════
        'lv-lv' => [
            'name' => 'Latviešu',
            'languageCode' => 'lv',
            'countryShortCode' => 'lv',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],

        // ══════════════════════════════════════════════════════════════════
        // ESTONIAN (et)
        // ══════════════════════════════════════════════════════════════════
        'et-ee' => [
            'name' => 'Eesti',
            'languageCode' => 'et',
            'countryShortCode' => 'ee',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],

        // ══════════════════════════════════════════════════════════════════
        // ALBANIAN (sq)
        // ══════════════════════════════════════════════════════════════════
        'sq-al' => [
            'name' => 'Shqip',
            'languageCode' => 'sq',
            'countryShortCode' => 'al',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],

        // ══════════════════════════════════════════════════════════════════
        // MACEDONIAN (mk)
        // ══════════════════════════════════════════════════════════════════
        'mk-mk' => [
            'name' => 'Македонски',
            'languageCode' => 'mk',
            'countryShortCode' => 'mk',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],

        // ══════════════════════════════════════════════════════════════════
        // BOSNIAN (bs)
        // ══════════════════════════════════════════════════════════════════
        'bs-ba' => [
            'name' => 'Bosanski',
            'languageCode' => 'bs',
            'countryShortCode' => 'ba',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],

        // ══════════════════════════════════════════════════════════════════
        // BELARUSIAN (be)
        // ══════════════════════════════════════════════════════════════════
        'be-by' => [
            'name' => 'Беларуская',
            'languageCode' => 'be',
            'countryShortCode' => 'by',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],

        // ══════════════════════════════════════════════════════════════════
        // ICELANDIC (is)
        // ══════════════════════════════════════════════════════════════════
        'is-is' => [
            'name' => 'Íslenska',
            'languageCode' => 'is',
            'countryShortCode' => 'is',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],

        // ══════════════════════════════════════════════════════════════════
        // CATALAN (ca)
        // ══════════════════════════════════════════════════════════════════
        'ca-ad' => [
            'name' => 'Català (Andorra)',
            'languageCode' => 'ca',
            'countryShortCode' => 'ad',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'ca-es' => [
            'name' => 'Català (Espanya)',
            'languageCode' => 'ca',
            'countryShortCode' => 'es',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => false,
        ],

        // ══════════════════════════════════════════════════════════════════
        // IRISH (ga)
        // ══════════════════════════════════════════════════════════════════
        'ga-ie' => [
            'name' => 'Gaeilge',
            'languageCode' => 'ga',
            'countryShortCode' => 'ie',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => false,
        ],

        // ══════════════════════════════════════════════════════════════════
        // WELSH (cy)
        // ══════════════════════════════════════════════════════════════════
        'cy-gb' => [
            'name' => 'Cymraeg',
            'languageCode' => 'cy',
            'countryShortCode' => 'gb',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => false,
        ],

        // ══════════════════════════════════════════════════════════════════
        // MALTESE (mt)
        // ══════════════════════════════════════════════════════════════════
        'mt-mt' => [
            'name' => 'Malti',
            'languageCode' => 'mt',
            'countryShortCode' => 'mt',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],

        // ══════════════════════════════════════════════════════════════════
        // LUXEMBOURGISH (lb)
        // ══════════════════════════════════════════════════════════════════
        'lb-lu' => [
            'name' => 'Lëtzebuergesch',
            'languageCode' => 'lb',
            'countryShortCode' => 'lu',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],

        // ══════════════════════════════════════════════════════════════════
        // KURDISH (ku)
        // ══════════════════════════════════════════════════════════════════
        'ku-iq' => [
            'name' => 'Kurdî (عێراق)',
            'languageCode' => 'ku',
            'countryShortCode' => 'iq',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => false,
        ],

        // ══════════════════════════════════════════════════════════════════
        // GUARANI (gn)
        // ══════════════════════════════════════════════════════════════════
        'gn-py' => [
            'name' => "Avañe'ẽ",
            'languageCode' => 'gn',
            'countryShortCode' => 'py',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => false,
        ],

        // ══════════════════════════════════════════════════════════════════
        // QUECHUA (qu)
        // ══════════════════════════════════════════════════════════════════
        'qu-pe' => [
            'name' => 'Runa Simi (Perú)',
            'languageCode' => 'qu',
            'countryShortCode' => 'pe',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => false,
        ],
        'qu-bo' => [
            'name' => 'Runa Simi (Bolivia)',
            'languageCode' => 'qu',
            'countryShortCode' => 'bo',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => false,
        ],

        // ══════════════════════════════════════════════════════════════════
        // KYC ADDITIONAL LOCALES
        // ══════════════════════════════════════════════════════════════════
        'ar-dj' => [
            'name' => 'العربية (جيبوتي)',
            'languageCode' => 'ar',
            'countryShortCode' => 'dj',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => false,
        ],
        'ar-eh' => [
            'name' => 'العربية (الصحراء الغربية)',
            'languageCode' => 'ar',
            'countryShortCode' => 'eh',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'ar-ly' => [
            'name' => 'العربية (ليبيا)',
            'languageCode' => 'ar',
            'countryShortCode' => 'ly',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'ar-mr' => [
            'name' => 'العربية (موريتانيا)',
            'languageCode' => 'ar',
            'countryShortCode' => 'mr',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'ar-sd' => [
            'name' => 'العربية (السودان)',
            'languageCode' => 'ar',
            'countryShortCode' => 'sd',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'ar-tn' => [
            'name' => 'العربية (تونس)',
            'languageCode' => 'ar',
            'countryShortCode' => 'tn',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'az-az' => [
            'name' => 'Azərbaycan dili',
            'languageCode' => 'az',
            'countryShortCode' => 'az',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'da-fo' => [
            'name' => 'Dansk (Færøerne)',
            'languageCode' => 'da',
            'countryShortCode' => 'fo',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'da-gl' => [
            'name' => 'Dansk (Grønland)',
            'languageCode' => 'da',
            'countryShortCode' => 'gl',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-ai' => [
            'name' => 'English (Anguilla)',
            'languageCode' => 'en',
            'countryShortCode' => 'ai',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-as' => [
            'name' => 'English (American Samoa)',
            'languageCode' => 'en',
            'countryShortCode' => 'as',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-bm' => [
            'name' => 'English (Bermuda)',
            'languageCode' => 'en',
            'countryShortCode' => 'bm',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-bt' => [
            'name' => 'English (Bhutan)',
            'languageCode' => 'en',
            'countryShortCode' => 'bt',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-bw' => [
            'name' => 'English (Botswana)',
            'languageCode' => 'en',
            'countryShortCode' => 'bw',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-cc' => [
            'name' => 'English (Cocos Islands)',
            'languageCode' => 'en',
            'countryShortCode' => 'cc',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-ck' => [
            'name' => 'English (Cook Islands)',
            'languageCode' => 'en',
            'countryShortCode' => 'ck',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-cm' => [
            'name' => 'English (Cameroon)',
            'languageCode' => 'en',
            'countryShortCode' => 'cm',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => false,
        ],
        'en-cx' => [
            'name' => 'English (Christmas Island)',
            'languageCode' => 'en',
            'countryShortCode' => 'cx',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-er' => [
            'name' => 'English (Eritrea)',
            'languageCode' => 'en',
            'countryShortCode' => 'er',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-et' => [
            'name' => 'English (Ethiopia)',
            'languageCode' => 'en',
            'countryShortCode' => 'et',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-fj' => [
            'name' => 'English (Fiji)',
            'languageCode' => 'en',
            'countryShortCode' => 'fj',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-fk' => [
            'name' => 'English (Falkland Islands)',
            'languageCode' => 'en',
            'countryShortCode' => 'fk',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-fm' => [
            'name' => 'English (Micronesia)',
            'languageCode' => 'en',
            'countryShortCode' => 'fm',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-gi' => [
            'name' => 'English (Gibraltar)',
            'languageCode' => 'en',
            'countryShortCode' => 'gi',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-gm' => [
            'name' => 'English (Gambia)',
            'languageCode' => 'en',
            'countryShortCode' => 'gm',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-gu' => [
            'name' => 'English (Guam)',
            'languageCode' => 'en',
            'countryShortCode' => 'gu',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-im' => [
            'name' => 'English (Isle of Man)',
            'languageCode' => 'en',
            'countryShortCode' => 'im',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-io' => [
            'name' => 'English (BIOT)',
            'languageCode' => 'en',
            'countryShortCode' => 'io',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-je' => [
            'name' => 'English (Jersey)',
            'languageCode' => 'en',
            'countryShortCode' => 'je',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-ki' => [
            'name' => 'English (Kiribati)',
            'languageCode' => 'en',
            'countryShortCode' => 'ki',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-ky' => [
            'name' => 'English (Cayman Islands)',
            'languageCode' => 'en',
            'countryShortCode' => 'ky',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-lk' => [
            'name' => 'English (Sri Lanka)',
            'languageCode' => 'en',
            'countryShortCode' => 'lk',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-lr' => [
            'name' => 'English (Liberia)',
            'languageCode' => 'en',
            'countryShortCode' => 'lr',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-ls' => [
            'name' => 'English (Lesotho)',
            'languageCode' => 'en',
            'countryShortCode' => 'ls',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-mh' => [
            'name' => 'English (Marshall Islands)',
            'languageCode' => 'en',
            'countryShortCode' => 'mh',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-mp' => [
            'name' => 'English (Northern Mariana Islands)',
            'languageCode' => 'en',
            'countryShortCode' => 'mp',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-ms' => [
            'name' => 'English (Montserrat)',
            'languageCode' => 'en',
            'countryShortCode' => 'ms',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-mu' => [
            'name' => 'English (Mauritius)',
            'languageCode' => 'en',
            'countryShortCode' => 'mu',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-mv' => [
            'name' => 'English (Maldives)',
            'languageCode' => 'en',
            'countryShortCode' => 'mv',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-mw' => [
            'name' => 'English (Malawi)',
            'languageCode' => 'en',
            'countryShortCode' => 'mw',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-na' => [
            'name' => 'English (Namibia)',
            'languageCode' => 'en',
            'countryShortCode' => 'na',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-nr' => [
            'name' => 'English (Nauru)',
            'languageCode' => 'en',
            'countryShortCode' => 'nr',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-nu' => [
            'name' => 'English (Niue)',
            'languageCode' => 'en',
            'countryShortCode' => 'nu',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-pg' => [
            'name' => 'English (Papua New Guinea)',
            'languageCode' => 'en',
            'countryShortCode' => 'pg',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-pr' => [
            'name' => 'English (Puerto Rico)',
            'languageCode' => 'en',
            'countryShortCode' => 'pr',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => false,
        ],
        'en-pw' => [
            'name' => 'English (Palau)',
            'languageCode' => 'en',
            'countryShortCode' => 'pw',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-rw' => [
            'name' => 'English (Rwanda)',
            'languageCode' => 'en',
            'countryShortCode' => 'rw',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-sb' => [
            'name' => 'English (Solomon Islands)',
            'languageCode' => 'en',
            'countryShortCode' => 'sb',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-sc' => [
            'name' => 'English (Seychelles)',
            'languageCode' => 'en',
            'countryShortCode' => 'sc',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-sh' => [
            'name' => 'English (Saint Helena)',
            'languageCode' => 'en',
            'countryShortCode' => 'sh',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-sl' => [
            'name' => 'English (Sierra Leone)',
            'languageCode' => 'en',
            'countryShortCode' => 'sl',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-sz' => [
            'name' => 'English (Eswatini)',
            'languageCode' => 'en',
            'countryShortCode' => 'sz',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-tc' => [
            'name' => 'English (Turks and Caicos)',
            'languageCode' => 'en',
            'countryShortCode' => 'tc',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-tk' => [
            'name' => 'English (Tokelau)',
            'languageCode' => 'en',
            'countryShortCode' => 'tk',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-to' => [
            'name' => 'English (Tonga)',
            'languageCode' => 'en',
            'countryShortCode' => 'to',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-tv' => [
            'name' => 'English (Tuvalu)',
            'languageCode' => 'en',
            'countryShortCode' => 'tv',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-tz' => [
            'name' => 'English (Tanzania)',
            'languageCode' => 'en',
            'countryShortCode' => 'tz',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => false,
        ],
        'en-ug' => [
            'name' => 'English (Uganda)',
            'languageCode' => 'en',
            'countryShortCode' => 'ug',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-vg' => [
            'name' => 'English (British Virgin Islands)',
            'languageCode' => 'en',
            'countryShortCode' => 'vg',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-vi' => [
            'name' => 'English (U.S. Virgin Islands)',
            'languageCode' => 'en',
            'countryShortCode' => 'vi',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-vu' => [
            'name' => 'English (Vanuatu)',
            'languageCode' => 'en',
            'countryShortCode' => 'vu',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-ws' => [
            'name' => 'English (Samoa)',
            'languageCode' => 'en',
            'countryShortCode' => 'ws',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-zm' => [
            'name' => 'English (Zambia)',
            'languageCode' => 'en',
            'countryShortCode' => 'zm',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'en-zw' => [
            'name' => 'English (Zimbabwe)',
            'languageCode' => 'en',
            'countryShortCode' => 'zw',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'es-ea' => [
            'name' => 'Español (Ceuta y Melilla)',
            'languageCode' => 'es',
            'countryShortCode' => 'ea',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'es-gq' => [
            'name' => 'Español (Guinea Ecuatorial)',
            'languageCode' => 'es',
            'countryShortCode' => 'gq',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'es-ic' => [
            'name' => 'Español (Islas Canarias)',
            'languageCode' => 'es',
            'countryShortCode' => 'ic',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'es-pr' => [
            'name' => 'Español (Puerto Rico)',
            'languageCode' => 'es',
            'countryShortCode' => 'pr',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fa-af' => [
            'name' => 'دری (افغانستان)',
            'languageCode' => 'fa',
            'countryShortCode' => 'af',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-bf' => [
            'name' => 'Français (Burkina Faso)',
            'languageCode' => 'fr',
            'countryShortCode' => 'bf',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-bi' => [
            'name' => 'Français (Burundi)',
            'languageCode' => 'fr',
            'countryShortCode' => 'bi',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-bj' => [
            'name' => 'Français (Bénin)',
            'languageCode' => 'fr',
            'countryShortCode' => 'bj',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-cd' => [
            'name' => 'Français (Congo-Kinshasa)',
            'languageCode' => 'fr',
            'countryShortCode' => 'cd',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-cf' => [
            'name' => 'Français (Centrafrique)',
            'languageCode' => 'fr',
            'countryShortCode' => 'cf',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-cg' => [
            'name' => 'Français (Congo-Brazzaville)',
            'languageCode' => 'fr',
            'countryShortCode' => 'cg',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-km' => [
            'name' => 'Français (Comores)',
            'languageCode' => 'fr',
            'countryShortCode' => 'km',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-ci' => [
            'name' => 'Français (Côte d\'Ivoire)',
            'languageCode' => 'fr',
            'countryShortCode' => 'ci',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-cm' => [
            'name' => 'Français (Cameroun)',
            'languageCode' => 'fr',
            'countryShortCode' => 'cm',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-dj' => [
            'name' => 'Français (Djibouti)',
            'languageCode' => 'fr',
            'countryShortCode' => 'dj',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-ga' => [
            'name' => 'Français (Gabon)',
            'languageCode' => 'fr',
            'countryShortCode' => 'ga',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-gn' => [
            'name' => 'Français (Guinée)',
            'languageCode' => 'fr',
            'countryShortCode' => 'gn',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-mf' => [
            'name' => 'Français (Saint-Martin)',
            'languageCode' => 'fr',
            'countryShortCode' => 'mf',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-mg' => [
            'name' => 'Français (Madagascar)',
            'languageCode' => 'fr',
            'countryShortCode' => 'mg',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-ml' => [
            'name' => 'Français (Mali)',
            'languageCode' => 'fr',
            'countryShortCode' => 'ml',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-nc' => [
            'name' => 'Français (Nouvelle-Calédonie)',
            'languageCode' => 'fr',
            'countryShortCode' => 'nc',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-ne' => [
            'name' => 'Français (Niger)',
            'languageCode' => 'fr',
            'countryShortCode' => 'ne',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-pm' => [
            'name' => 'Français (Saint-Pierre-et-Miquelon)',
            'languageCode' => 'fr',
            'countryShortCode' => 'pm',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-rw' => [
            'name' => 'Français (Rwanda)',
            'languageCode' => 'fr',
            'countryShortCode' => 'rw',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => false,
        ],
        'fr-sn' => [
            'name' => 'Français (Sénégal)',
            'languageCode' => 'fr',
            'countryShortCode' => 'sn',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-td' => [
            'name' => 'Français (Tchad)',
            'languageCode' => 'fr',
            'countryShortCode' => 'td',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-tg' => [
            'name' => 'Français (Togo)',
            'languageCode' => 'fr',
            'countryShortCode' => 'tg',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'fr-wf' => [
            'name' => 'Français (Wallis-et-Futuna)',
            'languageCode' => 'fr',
            'countryShortCode' => 'wf',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'hi-in' => [
            'name' => 'हिन्दी (भारत)',
            'languageCode' => 'hi',
            'countryShortCode' => 'in',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => false,
        ],
        'hy-am' => [
            'name' => 'Հայերեն (Հայաստusage)',
            'languageCode' => 'hy',
            'countryShortCode' => 'am',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'id-id' => [
            'name' => 'Bahasa Indonesia',
            'languageCode' => 'id',
            'countryShortCode' => 'id',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'it-va' => [
            'name' => 'Italiano (Città del Vaticano)',
            'languageCode' => 'it',
            'countryShortCode' => 'va',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'ka-ge' => [
            'name' => 'ქართული (საქართველო)',
            'languageCode' => 'ka',
            'countryShortCode' => 'ge',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'kk-kz' => [
            'name' => 'Қазақша (Қазақstан)',
            'languageCode' => 'kk',
            'countryShortCode' => 'kz',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'ko-kr' => [
            'name' => '한국어 (대한민국)',
            'languageCode' => 'ko',
            'countryShortCode' => 'kr',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'ky-kg' => [
            'name' => 'Кыrgyzча (Кыргызstан)',
            'languageCode' => 'ky',
            'countryShortCode' => 'kg',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'lo-la' => [
            'name' => 'ລາວ (ລາວ)',
            'languageCode' => 'lo',
            'countryShortCode' => 'la',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'mn-mn' => [
            'name' => 'Монгол (Монгол)',
            'languageCode' => 'mn',
            'countryShortCode' => 'mn',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'ms-bn' => [
            'name' => 'Bahasa Melayu (Brunei)',
            'languageCode' => 'ms',
            'countryShortCode' => 'bn',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'ms-my' => [
            'name' => 'Bahasa Melayu (Malaysia)',
            'languageCode' => 'ms',
            'countryShortCode' => 'my',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => false,
        ],
        'my-mm' => [
            'name' => 'မြန်မာ (မြန်မာ)',
            'languageCode' => 'my',
            'countryShortCode' => 'mm',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'nb-sj' => [
            'name' => 'Norsk bokmål (Svalbard)',
            'languageCode' => 'nb',
            'countryShortCode' => 'sj',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'ne-np' => [
            'name' => 'नेपाली (नेपाल)',
            'languageCode' => 'ne',
            'countryShortCode' => 'np',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'nl-aw' => [
            'name' => 'Nederlands (Aruba)',
            'languageCode' => 'nl',
            'countryShortCode' => 'aw',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'pt-ao' => [
            'name' => 'Português (Angola)',
            'languageCode' => 'pt',
            'countryShortCode' => 'ao',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'pt-cv' => [
            'name' => 'Português (Cabo Verde)',
            'languageCode' => 'pt',
            'countryShortCode' => 'cv',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'pt-gw' => [
            'name' => 'Português (Guiné-Bissau)',
            'languageCode' => 'pt',
            'countryShortCode' => 'gw',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'pt-mz' => [
            'name' => 'Português (Moçambique)',
            'languageCode' => 'pt',
            'countryShortCode' => 'mz',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'pt-st' => [
            'name' => 'Português (São Tomé e Príncipe)',
            'languageCode' => 'pt',
            'countryShortCode' => 'st',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'pt-tl' => [
            'name' => 'Português (Timor-Leste)',
            'languageCode' => 'pt',
            'countryShortCode' => 'tl',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'ru-kz' => [
            'name' => 'Русский (Казахstан)',
            'languageCode' => 'ru',
            'countryShortCode' => 'kz',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => false,
        ],
        'so-so' => [
            'name' => 'Soomaali (Soomaaliya)',
            'languageCode' => 'so',
            'countryShortCode' => 'so',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'sq-xk' => [
            'name' => 'Shqip (Kosovë)',
            'languageCode' => 'sq',
            'countryShortCode' => 'xk',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],
        'sr-xk' => [
            'name' => 'Српски (Косово)',
            'languageCode' => 'sr',
            'countryShortCode' => 'xk',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => false,
        ],
        'sw-tz' => [
            'name' => 'Kiswahili (Tanzania)',
            'languageCode' => 'sw',
            'countryShortCode' => 'tz',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'tg-tj' => [
            'name' => 'Тоҷикӣ (Тоҷикиstон)',
            'languageCode' => 'tg',
            'countryShortCode' => 'tj',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'th-th' => [
            'name' => 'ภาษาไทย (ประเทศไทย)',
            'languageCode' => 'th',
            'countryShortCode' => 'th',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'tk-tm' => [
            'name' => 'Türkmen (Türkmenistan)',
            'languageCode' => 'tk',
            'countryShortCode' => 'tm',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'uz-uz' => [
            'name' => 'O\'zbek (O\'zbekiston)',
            'languageCode' => 'uz',
            'countryShortCode' => 'uz',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'vi-vn' => [
            'name' => 'Tiếng Việt (Việt Nam)',
            'languageCode' => 'vi',
            'countryShortCode' => 'vn',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'zh-cn' => [
            'name' => '简体中文 (中国)',
            'languageCode' => 'zh',
            'countryShortCode' => 'cn',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
        'zh-mo' => [
            'name' => '繁體中文 (澳門)',
            'languageCode' => 'zh',
            'countryShortCode' => 'mo',
            'isDefaultLocaleForLanguage' => false,
            'isDefaultLocaleForCountry' => true,
        ],

        // ══════════════════════════════════════════════════════════════════
        // AYMARA (ay)
        // ══════════════════════════════════════════════════════════════════
        'ay-bo' => [
            'name' => 'Aymar aru',
            'languageCode' => 'ay',
            'countryShortCode' => 'bo',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => false,
        ],

        // ── Japanese ────────────────────────────────────────────
        'ja-jp' => [
            'name' => '日本語 (日本)',
            'languageCode' => 'ja',
            'countryShortCode' => 'jp',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],

        // ── Sinhala ─────────────────────────────────────────────
        'si-lk' => [
            'name' => 'සිංහල (ශ්‍රී ලංකාව)',
            'languageCode' => 'si',
            'countryShortCode' => 'lk',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],

        // ── Dhivehi ─────────────────────────────────────────────
        'dv-mv' => [
            'name' => 'ދިވެހި (ދިވެހިރާއްޖެ)',
            'languageCode' => 'dv',
            'countryShortCode' => 'mv',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],

        // ── Dzongkha ────────────────────────────────────────────
        'dz-bt' => [
            'name' => 'རྫོང་ཁ (འབྲུག)',
            'languageCode' => 'dz',
            'countryShortCode' => 'bt',
            'isDefaultLocaleForLanguage' => true,
            'isDefaultLocaleForCountry' => true,
        ],
    ],
];
