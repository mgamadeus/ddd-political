<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Repo\DB\PoliticalEntities\PoliticalRegions;

use DDD\Domain\Base\Repo\DB\Doctrine\DoctrineModel;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use DateTime;
use DDD\Domain\Base\Repo\DB\Database\DatabaseColumn;
use DDD\Domain\Common\Repo\DB\PoliticalEntities\Countries\DBCountryModel;

#[ORM\Entity]
#[ORM\ChangeTrackingPolicy('DEFERRED_EXPLICIT')]
#[ORM\Table(name: 'PoliticalRegions')]
class DBPoliticalRegionModel extends DoctrineModel
{
	public const MODEL_ALIAS = 'PoliticalRegion';

	public const TABLE_NAME = 'PoliticalRegions';

	public const ENTITY_CLASS = 'App\Domain\Common\Entities\PoliticalEntities\PoliticalRegions\PoliticalRegion';

	#[ORM\Column(type: 'string')]
	public ?string $slug;

	#[ORM\Column(type: 'string')]
	public ?string $shortCode;

	#[ORM\Column(type: 'string')]
	public ?string $numericCode;

	#[ORM\Column(type: 'integer')]
	public ?int $parentPoliticalRegionId;

	#[DatabaseColumn(isMergableJSONColumn: true)]
	#[ORM\Column(type: 'json')]
	public mixed $name;

	#[ORM\Column(type: 'integer')]
	public ?int $displayOrder = 0;

	#[ORM\Column(type: 'boolean')]
	public ?bool $isActive = true;

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: 'integer')]
	public int $id;

	#[ORM\ManyToOne(targetEntity: DBPoliticalRegionModel::class)]
	#[ORM\JoinColumn(name: 'parentPoliticalRegionId', referencedColumnName: 'id')]
	public ?DBPoliticalRegionModel $parentPoliticalRegion;

	#[ORM\OneToMany(targetEntity: DBPoliticalRegionModel::class, mappedBy: 'parentPoliticalRegion')]
	public PersistentCollection $childPoliticalRegions;

	#[ORM\OneToMany(targetEntity: DBCountryModel::class, mappedBy: 'politicalRegion')]
	public PersistentCollection $countries;

}