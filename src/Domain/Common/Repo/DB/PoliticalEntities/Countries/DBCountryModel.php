<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Repo\DB\PoliticalEntities\Countries;

use DDD\Domain\Base\Repo\DB\Doctrine\DoctrineModel;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use DateTime;
use DDD\Domain\Common\Repo\DB\PoliticalEntities\PoliticalRegions\DBPoliticalRegionModel;
use DDD\Domain\Base\Repo\DB\Database\DatabaseColumn;
use DDD\Domain\Common\Repo\DB\Locales\DBLocaleModel;

#[ORM\Entity]
#[ORM\ChangeTrackingPolicy('DEFERRED_EXPLICIT')]
#[ORM\Table(name: 'Countries')]
class DBCountryModel extends DoctrineModel
{
	public const string MODEL_ALIAS = 'Country';

	public const string TABLE_NAME = 'Countries';

	public const string ENTITY_CLASS = 'DDD\Domain\Common\Entities\PoliticalEntities\Countries\Country';

	public static array $virtualColumns = ['virtualNameSearch' => [ 'createIndex' => false, 'stored' => true, 'as' => '( CASE WHEN name IS NULL OR JSON_VALID(name) = 0 THEN \'\' ELSE REGEXP_REPLACE( TRIM( BOTH \' \' FROM REGEXP_REPLACE( REGEXP_REPLACE(JSON_UNQUOTE(name), \'^\\\\{\\\\s*|\\\\s*\\\\}\\\\s*$\', \'\'), \'"[^"]+"\\\\s*:\\\\s*"([^"]*)"\\\\s*(,\\\\s*)?\', \'\\\\1 | \' ) ), \'\\\\s*\\\\|\\\\s*$\', \'\' ) END )', 'referenceColumn' => 'nameSearch', 'referenceColumnStored' => true, ]];

	#[DatabaseColumn(isMergableJSONColumn: true)]
	#[ORM\Column(type: 'json')]
	public mixed $name;

	#[ORM\Column(type: 'string')]
	public ?string $slug;

	#[ORM\Column(type: 'integer')]
	public ?int $parentCountryId;

	#[ORM\Column(type: 'integer')]
	public ?int $politicalRegionId;

	#[ORM\Column(type: 'string')]
	public ?string $type = 'COUNTRY';

	#[ORM\Column(type: 'string')]
	public ?string $tld;

	#[ORM\Column(type: 'string')]
	public ?string $commonTld;

	#[ORM\Column(type: 'string')]
	public ?string $shortCode;

	#[ORM\Column(type: 'string')]
	public ?string $isoCode;

	#[ORM\Column(type: 'integer')]
	public ?int $phonePrefix;

	#[ORM\Column(type: 'string')]
	public ?string $nativeLanguageCode;

	#[ORM\Column(type: 'json')]
	public mixed $setting;

	#[ORM\Column(type: 'json')]
	public mixed $addressSetting;

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: 'integer')]
	public int $id;

	#[ORM\Column(type: 'string')]
	public string $virtualNameSearch;

	#[ORM\ManyToOne(targetEntity: DBCountryModel::class)]
	#[ORM\JoinColumn(name: 'parentCountryId', referencedColumnName: 'id')]
	public ?DBCountryModel $parentCountry;

	#[ORM\ManyToOne(targetEntity: DBPoliticalRegionModel::class)]
	#[ORM\JoinColumn(name: 'politicalRegionId', referencedColumnName: 'id')]
	public ?DBPoliticalRegionModel $politicalRegion;

	#[ORM\OneToMany(targetEntity: DBLocaleModel::class, mappedBy: 'country')]
	public PersistentCollection $locales;

}