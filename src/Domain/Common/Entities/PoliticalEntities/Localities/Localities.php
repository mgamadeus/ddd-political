<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Entities\PoliticalEntities\Localities;

use DDD\Domain\Common\Repo\DB\PoliticalEntities\Localities\DBLocalities;
use DDD\Domain\Common\Services\PoliticalEntities\LocalitiesService;
use DDD\Domain\Base\Entities\EntitySet;
use DDD\Domain\Base\Entities\LazyLoad\LazyLoadRepo;

/**
 * @property Locality[] $elements
 * @method Locality first()
 * @method Locality getByUniqueKey(string $uniqueKey)
 * @method Locality[] getElements()
 */
#[LazyLoadRepo(LazyLoadRepo::DB, DBLocalities::class)]
class Localities extends EntitySet
{
    public const string SERVICE_NAME = LocalitiesService::class;
}
