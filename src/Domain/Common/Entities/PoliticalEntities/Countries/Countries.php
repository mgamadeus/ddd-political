<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Entities\PoliticalEntities\Countries;

use DDD\Domain\Common\Repo\DB\PoliticalEntities\Countries\DBCountries;
use DDD\Domain\Common\Services\PoliticalEntities\CountriesService;
use DDD\Domain\Base\Entities\BaseObject;
use DDD\Domain\Base\Entities\EntitySet;
use DDD\Domain\Base\Entities\LazyLoad\LazyLoadRepo;
use DDD\Domain\Base\Entities\QueryOptions\QueryOptionsTrait;

/**
 * Collection of Country entities
 *
 * @property Country[] $elements
 * @method Country getByUniqueKey(string $uniqueKey)
 * @method Country[] getElements()
 * @method Country first()
 * @method static CountriesService getService()
 * @method static DBCountries getRepoClassInstance(string $repoType = null)
 */
#[LazyLoadRepo(LazyLoadRepo::DB, DBCountries::class)]
class Countries extends EntitySet
{
    use QueryOptionsTrait;

    public const string SERVICE_NAME = CountriesService::class;

    /** @var array<string, Country> Countries indexed by short code */
    protected array $countriesByCountryCode = [];

    /**
     * @param Country|null ...$countries
     * @return void
     */
    public function add(?BaseObject &...$countries): void
    {
        parent::add(...$countries);
        foreach ($countries as $country) {
            $this->countriesByCountryCode[$country->shortCode] = $country;
        }
    }

    public function getCountryByShortCode(string $shortCode): ?Country
    {
        return $this->countriesByCountryCode[$shortCode] ?? null;
    }

    /**
     * @param array $shortCodes
     * @return Countries|null
     */
    public function getCountriesByShortCodes(array $shortCodes): ?Countries
    {
        $countries = new Countries();
        foreach ($shortCodes as $shortCode) {
            $country = $this->getCountryByShortCode($shortCode);
            if ($country) {
                $countries->add($country);
            }
        }
        return $countries;
    }
}
