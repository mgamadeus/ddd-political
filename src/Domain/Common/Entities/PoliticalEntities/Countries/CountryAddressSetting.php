<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Entities\PoliticalEntities\Countries;

use DDD\Domain\Common\Entities\Settings\Settings;
use DDD\Domain\Base\Entities\ValueObject;

/**
 * @method Country getParent()
 */
class CountryAddressSetting extends ValueObject
{
    /** @var string Address format with number first */
    public const string STREET_NO_FORMAT_STREETNO_FIRST = '%no% %street%';

    /** @var string Address format with street name first */
    public const string STREET_NO_FORMAT_STREET_FIRST = '%street% %no%';

    /** @var string|null */
    public ?string $type = 'CountryAddressSetting';

    /** @var bool Street no. is mandatory in addresses */
    public bool $streetNoIsMandatory = false;

    /** @var bool Street is mandatory in addresses */
    public bool $streetIsMandatory = false;

    /** @var bool Locality (city/town) is mandatory in addresses */
    public bool $localityIsMandatory = true;

    /** @var bool Postal code is mandatory in addresses */
    public bool $postalCodeIsMandatory = true;

    /** @var bool State (administrative area level 1) is mandatory in addresses, e.g. USA, Mexico is mandatory */
    public bool $stateIsMandatory = false;

    /** @var bool County / Province (administrative area level 2) e.g. Madrid, La Rioja etc. Spain / Italy is mandatory */
    public bool $countyIsMandatory = false;

    /** @var bool County / Province (administrative area level 2) e.g. NA for Napoli is mandatory */
    public bool $countyShortCodeIsMandatory = false;

    /** @var bool Sub-County (administrativ areay level 3) e.g. Firence Italy */
    public bool $subCountyIsMandatory = false;


    /** @var bool Street no. is written before street in addresses */
    public bool $streetNoIsBeforeStreet = false;

    /** @var bool Locality (city/town) is written before postal code in addresses */
    public bool $localityIsBeforePostalcode = false;

    /** @var string Format of streetNo vs Street */
    public string $streetNoFormat = self::STREET_NO_FORMAT_STREET_FIRST;

    /** @var string|null Full Address format, e.g. %street% %number%, %postalCode% %city%, %country.name% */
    public ?string $addressFormat;
}