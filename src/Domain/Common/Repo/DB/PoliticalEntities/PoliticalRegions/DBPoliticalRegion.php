<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Repo\DB\PoliticalEntities\PoliticalRegions;

use DDD\Domain\Common\Entities\PoliticalEntities\PoliticalRegions\PoliticalRegion;
use DDD\Domain\Base\Entities\DefaultObject;
use DDD\Domain\Base\Repo\DB\DBEntity;
use DDD\Domain\Base\Repo\DB\Doctrine\DoctrineModel;
use DDD\Domain\Base\Repo\DB\Doctrine\DoctrineQueryBuilder;

/**
 * @method PoliticalRegion find(DoctrineQueryBuilder|string|int $idOrQueryBuilder, bool $useEntityRegistryCache = true, ?DoctrineModel &$loadedOrmInstance = null, bool $deferredCaching = false)
 * @method PoliticalRegion update(DefaultObject &$entity, int $depth = 1)
 * @property DBPoliticalRegionModel $ormInstance
 */
class DBPoliticalRegion extends DBEntity
{
    /** @var string Entity class managed by this repository */
    public const BASE_ENTITY_CLASS = PoliticalRegion::class;

    /** @var string Auto-generated Doctrine model class for this repository */
    public const BASE_ORM_MODEL = DBPoliticalRegionModel::class;
}
