<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Repo\Argus\PoliticalEntities;

use DDD\Domain\Base\Repo\Argus\Attributes\ArgusLoad;
use DDD\Domain\Base\Repo\Argus\Traits\ArgusTrait;
use DDD\Domain\Base\Repo\Argus\Utils\ArgusApiOperation;
use DDD\Domain\Base\Repo\Argus\Utils\ArgusCache;
use DDD\Domain\Common\Entities\PoliticalEntities\States\State;
use DDD\Domain\Base\Entities\DefaultObject;
use DDD\Domain\Common\Entities\GeoEntities\GeoPoint;
use DDD\Infrastructure\Cache\Cache;

/**
 * Argus repository entity for forward geocoding a State (administrative_area_level_1)
 * by name via the geocodeState batch endpoint.
 *
 * Requires the country relation to be set on the State before calling fromEntity().
 * The country->shortCode is used to restrict geocoding results geographically.
 *
 * @method State toEntity(array $callPath = [], DefaultObject|null &$entityInstance = null)
 */
#[ArgusLoad(
    loadEndpoint: 'POST:/common/geodata/geocodeState',
    cacheLevel: ArgusCache::CACHELEVEL_MEMORY_AND_DB,
    cacheTtl: Cache::CACHE_TTL_ONE_MONTH
)]
class ArgusState extends State
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
     * Builds the payload for the geocodeState batch endpoint.
     * Requires name to be set with the state/region name.
     *
     * @return array|null
     */
    protected function getLoadPayload(): ?array
    {
        if (!isset($this->name) || empty($this->name)) {
            return null;
        }

        $body = [
            'name' => $this->name,
        ];

        if ($this->currentLanguageCode ?? null) {
            $body['language'] = $this->currentLanguageCode;
        }

        $countryCode = $this->resolveCountryShortCode();
        if ($countryCode) {
            $body['country'] = $countryCode;
        }

        return ['body' => $body];
    }

    /**
     * Returns a unique cache key based on name, language and country
     *
     * @return string
     */
    public function uniqueKey(): string
    {
        $name = $this->name ?? '';
        $language = $this->currentLanguageCode ?? 'en';
        $country = $this->resolveCountryShortCode() ?? '';

        return static::uniqueKeyStatic("{$name}_{$language}_$country");
    }

    /**
     * Processes the response from the geocodeState batch endpoint.
     * Extracts state shortCode and geoPoint from the administrative_area_level_1 result.
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

            // Extract administrative_area_level_1 from addressComponents (v4 format)
            if (isset($result->addressComponents)) {
                foreach ($result->addressComponents as $component) {
                    if (in_array('administrative_area_level_1', $component->types ?? [])) {
                        $this->name = $component->longText ?? null;
                        $this->shortCode = $component->shortText ?? null;
                        break;
                    }
                }
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
