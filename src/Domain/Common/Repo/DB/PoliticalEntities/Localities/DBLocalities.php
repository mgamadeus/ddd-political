<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Repo\DB\PoliticalEntities\Localities;

use DDD\Domain\Common\Entities\PoliticalEntities\Localities\Localities;
use DDD\Domain\Base\Repo\DB\DBEntitySet;
use DDD\Domain\Base\Repo\DB\Doctrine\DoctrineQueryBuilder;

/**
 * @method Localities find(DoctrineQueryBuilder $queryBuilder = null, $useEntityRegistrCache = true)
 */
class DBLocalities extends DBEntitySet
{
    public const BASE_REPO_CLASS = DBLocality::class;
    public const BASE_ENTITY_SET_CLASS = Localities::class;
}
