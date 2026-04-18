<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Repo\Argus\PoliticalEntities;

use DDD\Domain\Base\Repo\Argus\Attributes\ArgusLoad;
use DDD\Domain\Base\Repo\Argus\Traits\ArgusTrait;
use DDD\Domain\Base\Repo\Argus\Utils\ArgusApiOperation;
use DDD\Domain\Base\Repo\Argus\Utils\ArgusCache;
use DDD\Domain\Common\Entities\PoliticalEntities\Localities\Locality;
use DDD\Domain\Base\Entities\DefaultObject;
use DDD\Domain\Common\Entities\GeoEntities\GeoPoint;
use DDD\Infrastructure\Cache\Cache;

/**
 * Argus repository entity for forward geocoding a Locality (locality/postal_town)
 * by name via the geocodeCity batch endpoint.
 *
 * Requires the country relation to be set on the Locality before calling fromEntity().
 * The country->shortCode is used to restrict geocoding results geographically.
 *
 * @method Locality toEntity(array $callPath = [], DefaultObject|null &$entityInstance = null)
 */
#[ArgusLoad(
    loadEndpoint: 'POST:/common/geodata/geocodeCity',
    cacheLevel: ArgusCache::CACHELEVEL_MEMORY_AND_DB,
    cacheTtl: Cache::CACHE_TTL_ONE_MONTH
)]
class ArgusLocality extends Locality
{
    use ArgusTrait;

    /**
     * Resolves the country short code from the lazy-loaded country relation
     *
     * @return string|null
     */
    protected function resolveCountryShortCode(): ?string
    {
        if (isset($this->country) && ($this->country->shortCode ?? null)) {
            return $this->country->shortCode;
        }

        return null;
    }

    /**
     * Resolves the state short code from the lazy-loaded state relation
     *
     * @return string|null
     */
    protected function resolveStateShortCode(): ?string
    {
        if (isset($this->state) && ($this->state->shortCode ?? null)) {
            return $this->state->shortCode;
        }

        return null;
    }

    /**
     * Builds the payload for the geocodeCity batch endpoint.
     * Requires either name or geoPoint (lat/lng) to be set.
     *
     * @return array|null
     */
    protected function getLoadPayload(): ?array
    {
        $hasName = isset($this->name) && !empty($this->name);
        $hasGeoPoint = isset($this->geoPoint->lat) && isset($this->geoPoint->lng);

        if (!$hasName && !$hasGeoPoint) {
            return null;
        }

        $body = [];

        if ($hasName) {
            $body['name'] = $this->name;
        }

        if ($hasGeoPoint) {
            $body['lat'] = $this->geoPoint->lat;
            $body['lng'] = $this->geoPoint->lng;
        }

        if ($this->currentLanguageCode ?? null) {
            $body['language'] = $this->currentLanguageCode;
        }

        $countryCode = $this->resolveCountryShortCode();
        if ($countryCode) {
            $body['country'] = $countryCode;
        }

        $stateCode = $this->resolveStateShortCode();
        if ($stateCode) {
            $body['state'] = $stateCode;
        }

        return ['body' => $body];
    }

    /**
     * Returns a unique cache key based on name, lat/lng, language, country and state
     *
     * @return string
     */
    public function uniqueKey(): string
    {
        $name = $this->name ?? '';
        $language = $this->currentLanguageCode ?? 'en';
        $country = $this->resolveCountryShortCode() ?? '';
        $state = $this->resolveStateShortCode() ?? '';

        $lat = '';
        $lng = '';
        if (isset($this->geoPoint->lat) && isset($this->geoPoint->lng)) {
            $lat = (string)$this->geoPoint->lat;
            $lng = (string)$this->geoPoint->lng;
        }

        return static::uniqueKeyStatic("{$name}_{$lat}_{$lng}_{$language}_{$country}_$state");
    }

    /**
     * Processes the response from the geocodeCity batch endpoint.
     * Extracts locality name, placeId and geoPoint from the locality result.
     *
     * @param mixed|null $callResponseData
     * @param ArgusApiOperation|null $apiOperation
     * @return void
     */
    public function handleLoadResponse(
        mixed &$callResponseData = null,
        ?ArgusApiOperation &$apiOperation = null
    ): void {
        if (!(($callResponseData->status ?? null) == 'OK' && ($callResponseData->data ?? null))) {
            $this->postProcessLoadResponse($callResponseData, false);
            return;
        }

        foreach ($callResponseData->data as $languageCode => $results) {
            if (empty($results) || !isset($results[0])) {
                break;
            }

            $result = $results[0];

            // Extract locality/postal_town from addressComponents for the locality name (v4 format)
            if (isset($result->addressComponents)) {
                $localityTypes = ['locality', 'postal_town', 'administrative_area_level_3', 'administrative_area_level_2'];
                foreach ($result->addressComponents as $component) {
                    $componentTypes = $component->types ?? [];
                    foreach ($localityTypes as $localityType) {
                        if (in_array($localityType, $componentTypes)) {
                            $this->name = $component->longText ?? null;
                            break 2;
                        }
                    }
                }
            }

            // Extract placeId (v4 format)
            if (isset($result->placeId)) {
                $this->placeId = $result->placeId;
            }

            // Extract geoPoint from location (v4: location.latitude / location.longitude)
            if (isset($result->location)) {
                $this->geoPoint = new GeoPoint(
                    $result->location->latitude ?? 0.0,
                    $result->location->longitude ?? 0.0
                );
            }

            break;
        }

        $this->postProcessLoadResponse($callResponseData);
    }
}
