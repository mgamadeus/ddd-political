<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Repo\DB\PoliticalEntities\Localities;

use DDD\Domain\Common\Entities\PoliticalEntities\Localities\Locality;
use DDD\Domain\Base\Entities\DefaultObject;
use DDD\Domain\Base\Repo\DB\DBEntity;
use DDD\Domain\Base\Repo\DB\Doctrine\DoctrineModel;
use DDD\Domain\Base\Repo\DB\Doctrine\DoctrineQueryBuilder;

/**
 * Database repository for Locality entities
 *
 * @method Locality find(DoctrineQueryBuilder|string|int $idOrQueryBuilder, bool $useEntityRegistryCache = true, ?DoctrineModel &$loadedOrmInstance = null, bool $deferredCaching = false)
 * @method Locality update(DefaultObject &$entity, int $depth = 1)
 * @property DBLocalityModel $ormInstance
 */
class DBLocality extends DBEntity
{
    public const BASE_ENTITY_CLASS = Locality::class;
    public const BASE_ORM_MODEL = DBLocalityModel::class;
}
