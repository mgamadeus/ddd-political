<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Entities\PoliticalEntities\States;

use DDD\Domain\Common\Repo\DB\PoliticalEntities\States\DBStates;
use DDD\Domain\Common\Services\PoliticalEntities\StatesService;
use DDD\Domain\Base\Entities\EntitySet;
use DDD\Domain\Base\Entities\LazyLoad\LazyLoadRepo;

/**
 * Collection of State entities
 *
 * @property State[] $elements
 * @method State getByUniqueKey(string $uniqueKey)
 * @method State[] getElements()
 * @method State first()
 * @method static StatesService getService()
 * @method static DBStates getRepoClassInstance(string $repoType = null)
 */
#[LazyLoadRepo(LazyLoadRepo::DB, DBStates::class)]
class States extends EntitySet
{
    public const string SERVICE_NAME = StatesService::class;
}
