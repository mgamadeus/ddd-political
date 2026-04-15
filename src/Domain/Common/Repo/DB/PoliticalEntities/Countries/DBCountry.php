<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Repo\DB\PoliticalEntities\Countries;

use DDD\Domain\Base\Entities\DefaultObject;
use DDD\Domain\Base\Repo\DB\DBEntity;
use DDD\Domain\Base\Repo\DB\Doctrine\DoctrineModel;
use DDD\Domain\Base\Repo\DB\Doctrine\DoctrineQueryBuilder;
use DDD\Domain\Common\Entities\PoliticalEntities\Countries\Country;

/**
 * Database repository for Country entities
 *
 * @method Country find(DoctrineQueryBuilder|string|int $idOrQueryBuilder, bool $useEntityRegistryCache = true, ?DoctrineModel &$loadedOrmInstance = null, bool $deferredCaching = false)
 * @method Country update(DefaultObject &$entity, int $depth = 1)
 * @property DBCountryModel $ormInstance
 */
class DBCountry extends DBEntity
{
    public const string BASE_ENTITY_CLASS = Country::class;

    public const string BASE_ORM_MODEL = DBCountryModel::class;
}
