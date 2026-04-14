<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Repo\DB\Locales;

use DDD\Domain\Common\Entities\Locales\Locale;
use DDD\Domain\Base\Entities\DefaultObject;
use DDD\Domain\Base\Repo\DB\DBEntity;
use DDD\Domain\Base\Repo\DB\Doctrine\DoctrineModel;
use DDD\Domain\Base\Repo\DB\Doctrine\DoctrineQueryBuilder;

/**
 * Database repository for Locale entities
 *
 * @method Locale find(DoctrineQueryBuilder|string|int $idOrQueryBuilder, bool $useEntityRegistryCache = true, ?DoctrineModel &$loadedOrmInstance = null, bool $deferredCaching = false)
 * @method Locale update(DefaultObject &$entity, int $depth = 1)
 * @property DBLocaleModel $ormInstance
 */
class DBLocale extends DBEntity
{
    public const BASE_ENTITY_CLASS = Locale::class;
    public const BASE_ORM_MODEL = DBLocaleModel::class;
}
