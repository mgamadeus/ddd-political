<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Repo\DB\PoliticalEntities\Localities;

use DDD\Domain\Base\Repo\DB\Doctrine\DoctrineModel;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use DateTime;
use DDD\Domain\Common\Repo\DB\PoliticalEntities\States\DBStateModel;
use DDD\Domain\Common\Repo\DB\PoliticalEntities\Countries\DBCountryModel;
use DDD\Domain\Base\Repo\DB\Database\DatabaseColumn;

#[ORM\Entity]
#[ORM\ChangeTrackingPolicy('DEFERRED_EXPLICIT')]
#[ORM\Table(name: 'Localities')]
class DBLocalityModel extends DoctrineModel
{
	public const string MODEL_ALIAS = 'Locality';

	public const string TABLE_NAME = 'Localities';

	public const string ENTITY_CLASS = 'DDD\Domain\Common\Entities\PoliticalEntities\Localities\Locality';

	public static array $virtualColumns = ['virtualNameSearch' => [ 'createIndex' => false, 'stored' => true, 'as' => '( CASE WHEN name IS NULL OR JSON_VALID(name) = 0 THEN \'\' ELSE REGEXP_REPLACE( TRIM( BOTH \' \' FROM REGEXP_REPLACE( REGEXP_REPLACE(JSON_UNQUOTE(name), \'^\\\\{\\\\s*|\\\\s*\\\\}\\\\s*$\', \'\'), \'"[^"]+"\\\\s*:\\\\s*"([^"]*)"\\\\s*(,\\\\s*)?\', \'\\\\1 | \' ) ), \'\\\\s*\\\\|\\\\s*$\', \'\' ) END )', 'referenceColumn' => 'nameSearch', 'referenceColumnStored' => true, ]];

	#[DatabaseColumn(isMergableJSONColumn: true)]
	#[ORM\Column(type: 'json')]
	public mixed $name;

	#[ORM\Column(type: 'string')]
	public ?string $slug;

	#[ORM\Column(type: 'integer')]
	public ?int $stateId;

	#[ORM\Column(type: 'integer')]
	public ?int $countryId;

	#[ORM\Column(type: 'string')]
	public ?string $placeId;

	#[ORM\Column(type: 'point')]
	public mixed $geoPoint;

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: 'integer')]
	public int $id;

	#[ORM\Column(type: 'datetime')]
	public ?DateTime $created;

	#[ORM\Column(type: 'datetime')]
	public ?DateTime $updated;

	#[ORM\Column(type: 'string')]
	public string $virtualNameSearch;

	#[ORM\ManyToOne(targetEntity: DBStateModel::class)]
	#[ORM\JoinColumn(name: 'stateId', referencedColumnName: 'id')]
	public ?DBStateModel $state;

	#[ORM\ManyToOne(targetEntity: DBCountryModel::class)]
	#[ORM\JoinColumn(name: 'countryId', referencedColumnName: 'id')]
	public ?DBCountryModel $country;

}