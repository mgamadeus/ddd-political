<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Repo\DB\PoliticalEntities\States;

use DDD\Domain\Base\Entities\DefaultObject;
use DDD\Domain\Base\Repo\DB\DBEntity;
use DDD\Domain\Base\Repo\DB\Doctrine\DoctrineModel;
use DDD\Domain\Base\Repo\DB\Doctrine\DoctrineQueryBuilder;
use DDD\Domain\Common\Entities\PoliticalEntities\States\State;

/**
 * Database repository for State entities
 *
 * @method State find(DoctrineQueryBuilder|string|int $idOrQueryBuilder, bool $useEntityRegistryCache = true, ?DoctrineModel &$loadedOrmInstance = null, bool $deferredCaching = false)
 * @method State update(DefaultObject &$entity, int $depth = 1)
 * @property DBStateModel $ormInstance
 */
class DBState extends DBEntity
{
    public const string BASE_ENTITY_CLASS = State::class;

    public const string BASE_ORM_MODEL = DBStateModel::class;
}
