<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Entities\PoliticalEntities\Counties;

use DDD\Domain\Base\Entities\ValueObject;

/**
 * County in terms of an administrative area level 2 (sub unit of State)
 */
class County extends ValueObject
{
    /** @var string|null The Counties full name */
    public ?string $name;

    /**
     * @var string|null The short name of the state
     * @example MA for Città Metropolitana di Napoli
     */
    public ?string $shortCode;

    public static function fromString(string $countyName): County
    {
        $county = new County();
        $county->name = $countyName;
        return $county;
    }
}