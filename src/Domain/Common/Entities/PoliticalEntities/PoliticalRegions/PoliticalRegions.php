<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Entities\PoliticalEntities\PoliticalRegions;

use DDD\Domain\Common\Repo\DB\PoliticalEntities\PoliticalRegions\DBPoliticalRegions;
use DDD\Domain\Common\Services\PoliticalEntities\PoliticalRegionsService;
use DDD\Domain\Base\Entities\EntitySet;
use DDD\Domain\Base\Entities\LazyLoad\LazyLoadRepo;
use DDD\Domain\Base\Entities\QueryOptions\QueryOptionsTrait;

/**
 * Collection of PoliticalRegion entities
 *
 * @property PoliticalRegion[] $elements
 * @method PoliticalRegion getByUniqueKey(string $uniqueKey)
 * @method PoliticalRegion[] getElements()
 * @method PoliticalRegion first()
 * @method static PoliticalRegionsService getService()
 */
#[LazyLoadRepo(LazyLoadRepo::DB, repoClass: DBPoliticalRegions::class)]
class PoliticalRegions extends EntitySet
{
    use QueryOptionsTrait;

    /** @var string Service class used for this entity set */
    public const string SERVICE_NAME = PoliticalRegionsService::class;
}
