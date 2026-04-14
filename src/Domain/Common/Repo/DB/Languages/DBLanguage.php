<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Repo\DB\Languages;

use DDD\Domain\Common\Entities\Languages\Language;
use DDD\Domain\Base\Entities\DefaultObject;
use DDD\Domain\Base\Repo\DB\DBEntity;
use DDD\Domain\Base\Repo\DB\Doctrine\DoctrineModel;
use DDD\Domain\Base\Repo\DB\Doctrine\DoctrineQueryBuilder;

/**
 * Database repository for Language entities
 *
 * @method Language find(DoctrineQueryBuilder|string|int $idOrQueryBuilder, bool $useEntityRegistryCache = true, ?DoctrineModel &$loadedOrmInstance = null, bool $deferredCaching = false)
 * @method Language update(DefaultObject &$entity, int $depth = 1)
 * @property DBLanguageModel $ormInstance
 */
class DBLanguage extends DBEntity
{
    public const BASE_ENTITY_CLASS = Language::class;
    public const BASE_ORM_MODEL = DBLanguageModel::class;
}
