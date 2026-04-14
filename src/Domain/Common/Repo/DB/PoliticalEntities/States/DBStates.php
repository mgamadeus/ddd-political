<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Repo\DB\PoliticalEntities\States;

use DDD\Domain\Common\Entities\PoliticalEntities\States\States;
use DDD\Domain\Base\Repo\DB\DBEntitySet;
use DDD\Domain\Base\Repo\DB\Doctrine\DoctrineQueryBuilder;

/**
 * @method States find(DoctrineQueryBuilder $queryBuilder = null, $useEntityRegistrCache = true)
 */
class DBStates extends DBEntitySet
{
    public const BASE_REPO_CLASS = DBState::class;
    public const BASE_ENTITY_SET_CLASS = States::class;
}
