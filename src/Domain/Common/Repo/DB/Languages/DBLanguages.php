<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Repo\DB\Languages;

use DDD\Domain\Common\Entities\Languages\Languages;
use DDD\Domain\Base\Repo\DB\DBEntitySet;
use DDD\Domain\Base\Repo\DB\Doctrine\DoctrineQueryBuilder;

/**
 * @method Languages find(DoctrineQueryBuilder $queryBuilder = null, $useEntityRegistrCache = true)
 */
class DBLanguages extends DBEntitySet
{
    public const string BASE_REPO_CLASS = DBLanguage::class;
    public const string BASE_ENTITY_SET_CLASS = Languages::class;
}
