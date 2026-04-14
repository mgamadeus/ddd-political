<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Repo\DB\PoliticalEntities\PoliticalRegions;

use DDD\Domain\Common\Entities\PoliticalEntities\PoliticalRegions\PoliticalRegions;
use DDD\Domain\Base\Repo\DB\DBEntitySet;
use DDD\Domain\Base\Repo\DB\Doctrine\DoctrineQueryBuilder;

/**
 * @method PoliticalRegions find(DoctrineQueryBuilder $queryBuilder = null, $useEntityRegistrCache = true)
 */
class DBPoliticalRegions extends DBEntitySet
{
    /** @var string Repository class used for single entity operations */
    public const BASE_REPO_CLASS = DBPoliticalRegion::class;

    /** @var string Entity set class returned by this repository */
    public const BASE_ENTITY_SET_CLASS = PoliticalRegions::class;
}
