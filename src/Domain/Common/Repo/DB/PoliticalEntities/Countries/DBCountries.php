<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Repo\DB\PoliticalEntities\Countries;

use DDD\Domain\Common\Entities\PoliticalEntities\Countries\Countries;
use DDD\Domain\Base\Repo\DB\DBEntitySet;
use DDD\Domain\Base\Repo\DB\Doctrine\DoctrineQueryBuilder;

/**
 * @method Countries find(DoctrineQueryBuilder $queryBuilder = null, $useEntityRegistrCache = true)
 */
class DBCountries extends DBEntitySet
{
    public const string BASE_REPO_CLASS = DBCountry::class;
    public const string BASE_ENTITY_SET_CLASS = Countries::class;
}
