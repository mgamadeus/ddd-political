# mgamadeus/ddd-common-political -- Political Module

Countries, languages, locales, political regions, states, and localities for the `mgamadeus/ddd` framework.

**Package:** `mgamadeus/ddd-common-political` (v1.0.x)
**Namespace:** `DDD\`
**Depends on:** `mgamadeus/ddd` (^2.10), `mgamadeus/ddd-argus` (^1.0)

> **This module follows all DDD Core conventions.** For base patterns, see skills in `vendor/mgamadeus/ddd`. For Argus patterns, see `vendor/mgamadeus/ddd-argus`.

## Architecture

```
src/Domain/Common/
+-- Entities/
|   +-- Languages/          [Language, Locale -- 66 languages, 312 locales]
|   +-- PoliticalEntities/
|       +-- Countries/      [Country, CountrySetting, CountryAddressSetting -- 236 countries]
|       +-- PoliticalRegions/ [PoliticalRegion -- 6 continents, 15 sub-regions]
|       +-- States/         [State -- admin level 1, geocoding via Argus]
|       +-- Localities/     [Locality -- cities, geocoding, proximity search]
|       +-- Counties/       [County, SubCounty -- ValueObjects for admin levels 2/3]
+-- Repo/
|   +-- Argus/PoliticalEntities/ [ArgusState, ArgusLocality -- geocoding repos]
|   +-- DB/                      [Doctrine repos for all persisted entities]
+-- Services/
    +-- Languages/           [LanguagesService, LocalesService]
    +-- PoliticalEntities/   [CountriesService, StatesService, LocalitiesService, PoliticalRegionsService]
config/app/Common/Political/ [Seed data: 236 countries, 66 languages, 312 locales, 21 regions]
```

## Entity Overview

| Entity | Type | Persisted | Key Feature |
|--------|------|-----------|-------------|
| **Country** | Entity | DB | 236 countries, ISO codes, multilingual names, address/unit settings |
| **PoliticalRegion** | Entity | DB | Self-referencing hierarchy: continents -> sub-regions |
| **State** | Entity | DB + Argus | Admin level 1, geocoding, translatable names |
| **Locality** | Entity | DB + Argus | Cities/towns, proximity search (ST_Distance_Sphere) |
| **Language** | Entity | DB | 66 languages, ISO 639-1/3, text direction (LTR/RTL), script codes |
| **Locale** | Entity | DB | 312 language+country combos, date/time formats |
| **County** | ValueObject | No | Admin level 2 (name + shortCode) |
| **SubCounty** | ValueObject | No | Admin level 3 (name + shortCode) |
| **CountrySetting** | ValueObject | JSON in Country | Unit system, time system, first day of week |
| **CountryAddressSetting** | ValueObject | JSON in Country | Address format templates, mandatory fields |

## Key Design Patterns

1. **Config-driven seed data** -- 236 countries, 66 languages, 312 locales imported from PHP config arrays with `importFromConfig()` methods
2. **Import order dependency** -- PoliticalRegions -> Countries -> Languages -> Locales
3. **Geocoding via Argus** -- States and Localities geocoded via `ArgusState`/`ArgusLocality` (1-month cache)
4. **Translatable names** -- Country, State, Locality, Language, PoliticalRegion names use `#[Translatable]`
5. **Proximity search** -- Localities searched by name + geographic radius (50km default, ST_Distance_Sphere)
6. **Self-referencing hierarchies** -- PoliticalRegion (continents -> sub-regions), Country (parent territories)
7. **Address formatting DSL** -- CountryAddressSetting with `%street%`, `%number%`, `%city%`, `%country.name%` templates

## Services

| Service | Key Methods |
|---------|-------------|
| **CountriesService** | `importCountriesFromConfig()`, `findByShortCode()`, `findDefaultLocaleForCountry()` |
| **StatesService** | `findOrCreateStateAndUpdateLocalizedName()`, `findByShortCodeAndCountry()`, `geoCodeStateUsingDefaultLocale()` |
| **LocalitiesService** | `findOrCreateLocalityAndUpdateLocalizedName()`, `findByPlaceId()`, `findLocalityByNameAndCoordinates()` |
| **PoliticalRegionsService** | `importPoliticalRegionsFromConfig()`, `findBySlug()` |
| **LanguagesService** | `importLanguagesFromConfig()`, `findByLanguageCode()`, `findActiveLanguages()` |
| **LocalesService** | `importLocalesFromConfig()`, `findByLanguageCodeAndCountryShortCode()`, `findActiveLocales()` |

## Environment Variables

```env
ARGUS_API_ENDPOINT=https://...              # For State/Locality geocoding
CLI_DEFAULT_ACCOUNT_ID_FOR_CLI_OPERATIONS=1 # SUPER_ADMIN for Argus auth
```
