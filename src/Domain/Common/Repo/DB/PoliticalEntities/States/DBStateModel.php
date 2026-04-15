<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Repo\DB\PoliticalEntities\States;

use DDD\Domain\Base\Repo\DB\Doctrine\DoctrineModel;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use DateTime;
use DDD\Domain\Common\Repo\DB\PoliticalEntities\Countries\DBCountryModel;
use DDD\Domain\Base\Repo\DB\Database\DatabaseColumn;

#[ORM\Entity]
#[ORM\ChangeTrackingPolicy('DEFERRED_EXPLICIT')]
#[ORM\Table(name: 'States')]
class DBStateModel extends DoctrineModel
{
	public const string MODEL_ALIAS = 'State';

	public const string TABLE_NAME = 'States';

	public const string ENTITY_CLASS = 'DDD\Domain\Common\Entities\PoliticalEntities\States\State';

	#[DatabaseColumn(isMergableJSONColumn: true)]
	#[ORM\Column(type: 'json')]
	public mixed $name;

	#[ORM\Column(type: 'string')]
	public ?string $slug;

	#[ORM\Column(type: 'string')]
	public ?string $shortCode;

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

	#[ORM\ManyToOne(targetEntity: DBCountryModel::class)]
	#[ORM\JoinColumn(name: 'countryId', referencedColumnName: 'id')]
	public ?DBCountryModel $country;

}