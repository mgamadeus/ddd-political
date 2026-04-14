<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Entities\Languages;

use DDD\Domain\Common\Repo\DB\Languages\DBLanguages;
use DDD\Domain\Common\Services\Languages\LanguagesService;
use DDD\Domain\Base\Entities\EntitySet;
use DDD\Domain\Base\Entities\LazyLoad\LazyLoadRepo;
use DDD\Domain\Base\Entities\QueryOptions\QueryOptionsTrait;

/**
 * Collection of Language entities
 *
 * @property Language[] $elements
 * @method Language getByUniqueKey(string $uniqueKey)
 * @method Language[] getElements()
 * @method Language first()
 * @method static LanguagesService getService()
 */
#[LazyLoadRepo(LazyLoadRepo::DB, DBLanguages::class)]
class Languages extends EntitySet
{
    use QueryOptionsTrait;

    public const string SERVICE_NAME = LanguagesService::class;
}
