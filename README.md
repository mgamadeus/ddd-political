# mgamadeus/ddd-common-political

Countries, languages, locales, political regions, states, and localities for the [mgamadeus/ddd](https://github.com/mgamadeus/ddd) framework.

## Installation

```bash
composer require mgamadeus/ddd-common-political
```

## What it does

Reference data entities for political geography and localization:

- **Country** — 236 countries with multilingual names, ISO codes, TLD, phone prefix, address formatting, political region mapping
- **PoliticalRegion** — hierarchical regions (6 continents → 15 sub-regions) with UN M49 codes
- **State** — administrative area level 1 with geocoding support
- **Locality** — city/town with GeoPoint, placeId, proximity search
- **Language** — 66 languages (ISO 639-1/3, text direction, script codes)
- **Locale** — 312 language+country combinations with date/time formats
- **County / SubCounty** — administrative levels 2 and 3 (value objects)

## Configuration (seed data)

The module ships with comprehensive seed data in `config/app/Common/Political/`:

| File | Contents |
|---|---|
| `Countries.php` | 236 countries with multilingual names (20+ translations each), ISO codes, political region mapping, address settings |
| `Languages.php` | 66 languages across 5 tiers with multilingual names, script codes |
| `Locales.php` | 312 locale entries with date/time format rules |
| `PoliticalRegions.php` | 6 continents + 15 sub-regions with UN M49 codes |

### Overriding config

Place a file at the same path in your project's `config/app/Common/Political/` to override. Project config is searched before module config.

For example, to add a custom country or change an existing entry, create `config/app/Common/Political/Countries.php` in your project with the full array — it replaces the module's version entirely.

## Service registration

Add to your project's `services.yaml`:

```yaml
# DDD Module: ddd-common-political
DDD\Domain\Common\Services\PoliticalEntities\:
    resource: '%kernel.project_dir%/vendor/mgamadeus/ddd-common-political/src/Domain/Common/Services/PoliticalEntities/*'
    public: true

DDD\Domain\Common\Services\Languages\:
    resource: '%kernel.project_dir%/vendor/mgamadeus/ddd-common-political/src/Domain/Common/Services/Languages/*'
    public: true
```

## Importing seed data

The module provides services with `importFromConfig()` methods. Create admin endpoints in your app that call these services:

```php
// Import political regions (must run first — countries reference them)
$politicalRegionsService = PoliticalRegion::getService();
$regions = $politicalRegionsService->importPoliticalRegionsFromConfig();

// Import countries (resolves political region slugs to IDs)
$countriesService = Country::getService();
$countries = $countriesService->importCountriesFromConfig($politicalRegionsService);

// Import languages
$languagesService = Language::getService();
$languages = $languagesService->importLanguagesFromConfig();

// Import locales (resolves languageId and countryId)
$localesService = Locale::getService();
$locales = $localesService->importLocalesFromConfig($languagesService, $countriesService);
```

### Import order

1. **PoliticalRegions** first (countries reference them)
2. **Countries** second (locales reference them)
3. **Languages** third (locales reference them)
4. **Locales** last (references both countries and languages)

## Geocoding (via Argus)

States and localities can be geocoded via the Argus API:

- `ArgusState` — `POST:/common/geodata/geocodeState` (1-month cache)
- `ArgusLocality` — `POST:/common/geodata/geocodeCity` (1-month cache)

These require `ARGUS_API_ENDPOINT` to be configured (see [ddd-argus](https://github.com/mgamadeus/ddd-argus)).

## Overriding entities

Extend any entity in your project using the standard DDD override mechanism:

```php
// App\Domain\Common\Entities\PoliticalEntities\Countries\Country
namespace App\Domain\Common\Entities\PoliticalEntities\Countries;

use DDD\Domain\Common\Entities\PoliticalEntities\Countries\Country as BaseCountry;

class Country extends BaseCountry
{
    public bool $requiresEnhancedVerification = false;
}
```

No `services.yaml` entry needed — the `DDD\ → App\` fallback resolves it automatically.
