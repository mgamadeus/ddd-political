<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Entities\PoliticalEntities\Counties;

use DDD\Domain\Base\Entities\ValueObject;

/**
 * SubCounty in terms of an administrative area level 3 (sub unit of County)
 */
class SubCounty extends ValueObject
{
    /** @var string|null The SubCounties full name */
    public ?string $name;

    /** @var string|null The short name of the SubCounty */
    public ?string $shortCode;

    public static function fromString(string $subCountyName): SubCounty
    {
        $subCounty = new SubCounty();
        $subCounty->name = $subCountyName;
        return $subCounty;
    }
}