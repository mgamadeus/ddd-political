---
name: ddd-module-political-specialist
description: Work with countries, languages, locales, political regions, states, and localities from the ddd-common-political module. Use when handling geographic reference data, localization, address formatting, or geocoding states/localities.
metadata:
  author: mgamadeus
  version: "1.0.0"
  module: mgamadeus/ddd-common-political
---

# Political Module Specialist

Countries, languages, locales, political regions, states, and localities.

> **Base patterns:** See core skills in `vendor/mgamadeus/ddd`. For Argus repos, see `vendor/mgamadeus/ddd-argus`.

## When to Use

- Looking up countries, languages, or locales
- Importing seed data (countries, languages, locales, political regions)
- Geocoding states or localities via Argus
- Working with address formatting rules per country
- Implementing proximity-based locality search

## Key Entities

### Country (236 countries)

```php
// Lookup
$countriesService = Countries::getService();
$germany = $countriesService->findByShortCode('DE');

// Properties
$germany->name;             // Translatable multilingual name
$germany->shortCode;        // 'DE' (ISO 3166-1 alpha-2)
$germany->isoCode;          // 'DEU' (ISO 3166-1 alpha-3)
$germany->phonePrefix;      // 49
$germany->nativeLanguageCode; // 'de'
$germany->tld;              // 'de'
$germany->setting;          // CountrySetting ValueObject
$germany->addressSetting;   // CountryAddressSetting ValueObject
$germany->locales;          // Lazy-loaded Locales
```

**CountrySetting:** `unitSystem` (METRIC/IMPERIAL), `timeSystem` (12H/24H), `firstDayOfWeek` (MONDAY/SUNDAY/SATURDAY/FRIDAY), `firstnameBeforeLastname`

**CountryAddressSetting:** `streetNoIsBeforeStreet`, `localityIsBeforePostalcode`, mandatory flags (street, postalCode, state, etc.), `addressFormat` template (`'%street% %number%, %postalCode% %city%'`)

### Language (66 languages)

```php
$languagesService = Languages::getService();
$german = $languagesService->findByLanguageCode('de');

$german->languageCode;        // 'de' (ISO 639-1)
$german->iso3Code;            // 'deu' (ISO 639-3)
$german->nativeName;          // 'Deutsch'
$german->textDirection;       // 'LTR' or 'RTL'
$german->scriptCode;          // 'Latn' (ISO 15924)
$german->supportedWritingStyles; // 'FORMAL', 'INFORMAL', 'FORMAL_AND_INFORMAL'
```

### Locale (312 combinations)

```php
$localesService = Locales::getService();
$deDE = $localesService->findByLanguageCodeAndCountryShortCode('de', 'DE');

$deDE->languageCode;              // 'de'
$deDE->countryShortCode;          // 'DE'
$deDE->isDefaultLocaleForLanguage; // true/false
$deDE->isDefaultLocaleForCountry;  // true/false

// Parse from string
$locale = Locale::fromString('de-DE');  // or 'de_DE'
```

### State (geocoded via Argus)

```php
$statesService = States::getService();

// Find or create with localized name
$state = $statesService->findOrCreateStateAndUpdateLocalizedName(
    currentLanguageCode: 'en',
    country: $country,
    localizedName: 'Bavaria',
    shortCode: 'BY'
);
// Geocodes via ArgusState if not found in DB
```

### Locality (geocoded, proximity search)

```php
$localitiesService = Localities::getService();

// Find or create
$locality = $localitiesService->findOrCreateLocalityAndUpdateLocalizedName(
    currentLanguageCode: 'en',
    country: $country,
    state: $state,
    localizedName: 'Munich',
    placeId: 'ChIJ2V-Mo_l1nkcRfZixfUq4DAE',
    geoPoint: $geoPoint
);

// Proximity search (50km default)
$nearby = $localitiesService->findLocalityByNameAndCoordinates(
    name: 'Munich',
    geoPoint: $geoPoint,
    searchRadiusInMeters: 50000
);
```

### PoliticalRegion (hierarchical)

6 continents -> 15 sub-regions (self-referencing `parentPoliticalRegionId`):

```php
$regionsService = PoliticalRegions::getService();
$europe = $regionsService->findBySlug('europe');
$eu = $regionsService->findBySlug('european-union');
// $eu->parentPoliticalRegion == $europe
```

## Importing Seed Data

**Order matters** -- entities reference each other:

```php
// 1. Political Regions (standalone)
$regions = PoliticalRegions::getService()->importPoliticalRegionsFromConfig();

// 2. Countries (references PoliticalRegions)
$countries = Countries::getService()->importCountriesFromConfig(PoliticalRegions::getService());

// 3. Languages (standalone)
$languages = Languages::getService()->importLanguagesFromConfig();

// 4. Locales (references Countries + Languages)
$locales = Locales::getService()->importLocalesFromConfig(Languages::getService(), Countries::getService());
```

Config files in `config/app/Common/Political/`: `Countries.php` (236), `Languages.php` (66), `Locales.php` (312), `PoliticalRegions.php` (21).

**Override:** Place same-path file in your project's `config/app/` -- project config takes priority.

## Argus Geocoding

| Argus Repo | Endpoint | Cache |
|-----------|----------|-------|
| `ArgusState` | `POST:/common/geodata/geocodeState` | 1 month |
| `ArgusLocality` | `POST:/common/geodata/geocodeCity` | 1 month |

Both support forward geocoding (name -> coordinates) and return placeId, shortCode, geoPoint.

ArgusLocality also supports reverse geocoding (coordinates -> locality) when `lat`/`lng` are provided instead of `name`.
