<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Entities\PoliticalEntities\Countries;

use DDD\Domain\Base\Entities\ValueObject;
use DDD\Infrastructure\Validation\Constraints\Choice;

class CountrySetting extends ValueObject
{
    /** @var string The metric unit system */
    public const string UNIT_SYSTEM_METRIC = 'METRIC';

    /** @var string The imperial unit system */
    public const string UNIT_SYSTEM_IMPERIAL = 'IMPERIAL';

    /** @var string The 12-hour time system */
    public const string TIME_SYSTEM_12H = '12H';

    /** @var string The 24-hour time system */
    public const string TIME_SYSTEM_24H = '24H';

    /** @var string The first day of the week - Monday */
    public const string FIRST_DAY_OF_WEEK_MONDAY = 'MONDAY';

    /** @var string The first day of the week - Sunday */
    public const string FIRST_DAY_OF_WEEK_SUNDAY = 'SUNDAY';

    /** @var string The first day of the week - SATURDAY */
    public const string FIRST_DAY_OF_WEEK_SATURDAY = 'SATURDAY';

    /** @var string The first day of the week - FRIDAY */
    public const string FIRST_DAY_OF_WEEK_FRIDAY = 'FRIDAY';

    /** @var string The country's default unit system */
    #[Choice(choices: [self::UNIT_SYSTEM_IMPERIAL, self::UNIT_SYSTEM_METRIC])]
    public string $unitSystem = self::UNIT_SYSTEM_METRIC;

    /** @var string The country's default time system (12H uses AM/PM) */
    #[Choice(choices: [self::TIME_SYSTEM_12H, self::TIME_SYSTEM_24H])]
    public string $timeSystem = self::TIME_SYSTEM_24H;

    /** @var string The day the week starts */
    #[Choice(choices: [self::FIRST_DAY_OF_WEEK_MONDAY, self::FIRST_DAY_OF_WEEK_SUNDAY, self::FIRST_DAY_OF_WEEK_SATURDAY, self::FIRST_DAY_OF_WEEK_FRIDAY])]
    public string $firstDayOfWeek = self::FIRST_DAY_OF_WEEK_MONDAY;

    /** @var string|null The default address format */
    public ?string $addressFormat;

    /** @var string|null The default language used in app, can differ from native language */
    public ?string $appDefaultLanguageCode;

    /** @var bool Whether country is active or not */
    public bool $isActive = true;

    /** @var int Priority, the lower the higher */
    public int $priority = 0;

    /** @var bool If true, the firstName is common to be written before lastName */
    public bool $firstnameBeforeLastname = true;
}
