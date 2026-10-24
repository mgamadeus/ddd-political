<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Services\PoliticalEntities;

use DDD\Domain\Base\Entities\QueryOptions\FiltersDefinitions;
use DDD\Domain\Base\Entities\QueryOptions\FiltersOptions;
use DDD\Domain\Base\Repo\DB\Doctrine\DoctrineQueryBuilder;
use DDD\Infrastructure\Exceptions\BadRequestException;
use DDD\Infrastructure\Exceptions\InternalErrorException;

/**
 * Name lookups of the political services through the declarative `fb` filter: Core picks the column (the virtual
 * search column of a `#[Translatable(fullTextIndex: true)]` name) and binds the value, so no MATCH is written by hand.
 */
trait NameFulltextFilterTrait
{
    /**
     * Narrows the query to rows whose name matches $name in fulltext boolean mode.
     *
     * @param DoctrineQueryBuilder $queryBuilder Query builder of the service's DB repo
     * @param string $name The name to search for, any characters (apostrophes included)
     * @param string $entityClass The entity the query builder selects, e.g. Locality::class
     * @return void
     * @throws BadRequestException
     * @throws InternalErrorException When the filter cannot be applied: Core leaves an expression it cannot resolve out
     *         of the query, which would drop the name condition silently and return an arbitrary row
     */
    protected function applyNameFulltextFilterToQueryBuilder(
        DoctrineQueryBuilder $queryBuilder,
        string $name,
        string $entityClass
    ): void {
        $filtersOptions = FiltersOptions::createExpression('name', FiltersOptions::OPERATOR_FULLTEXT_BOOLEAN, $name);
        $filtersDefinitions = FiltersDefinitions::getFiltersDefinitionsForReferenceClass($entityClass);
        if (!$filtersDefinitions || !$filtersOptions->validateAgainstDefinitions($filtersDefinitions)) {
            throw new InternalErrorException("The name fulltext filter does not validate against $entityClass");
        }
        // the fb expression binds exactly one parameter; none means Core resolved no column and applied nothing
        $parameterCountBefore = $queryBuilder->getParameters()->count();
        $filtersOptions->applyFiltersToDoctrineQueryBuilder($queryBuilder);
        if ($queryBuilder->getParameters()->count() === $parameterCountBefore) {
            throw new InternalErrorException("The name fulltext filter could not be applied to $entityClass");
        }
    }
}
