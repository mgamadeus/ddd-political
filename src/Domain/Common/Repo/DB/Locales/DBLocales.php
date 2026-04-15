<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Repo\DB\Locales;

use DDD\Domain\Common\Entities\Locales\Locales;
use DDD\Domain\Base\Repo\DB\DBEntitySet;
use DDD\Domain\Base\Repo\DB\Doctrine\DoctrineQueryBuilder;

/**
 * @method Locales find(DoctrineQueryBuilder $queryBuilder = null, $useEntityRegistrCache = true)
 */
class DBLocales extends DBEntitySet
{
    public const string BASE_REPO_CLASS = DBLocale::class;
    public const string BASE_ENTITY_SET_CLASS = Locales::class;
}
