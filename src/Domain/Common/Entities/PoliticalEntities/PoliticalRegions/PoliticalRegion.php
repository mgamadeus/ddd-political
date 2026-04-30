<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Entities\PoliticalEntities\PoliticalRegions;

use DDD\Domain\Common\Entities\PoliticalEntities\Countries\Countries;
use DDD\Domain\Common\Entities\Roles\Role;
use DDD\Domain\Common\Repo\DB\PoliticalEntities\PoliticalRegions\DBPoliticalRegion;
use DDD\Domain\Common\Services\PoliticalEntities\PoliticalRegionsService;
use DDD\Domain\Base\Entities\Attributes\RolesRequiredForUpdate;
use DDD\Domain\Base\Entities\Entity;
use DDD\Domain\Base\Entities\LazyLoad\LazyLoad;
use DDD\Domain\Base\Entities\LazyLoad\LazyLoadRepo;
use DDD\Domain\Base\Entities\QueryOptions\QueryOptionsTrait;
use DDD\Domain\Base\Entities\Translatable\Translatable;
use DDD\Domain\Base\Entities\Translatable\TranslatableTrait;
use DDD\Domain\Base\Repo\DB\Database\DatabaseIndex;
use Symfony\Component\Validator\Constraints\Length;

/**
 * Geographic/political region with self-referencing hierarchy.
 * Top-level entries (parentPoliticalRegionId = null) are continents/macro-regions.
 * Child entries are sub-regions grouped by regulatory/business similarity.
 *
 * @method static PoliticalRegionsService getService()
 * @method static DBPoliticalRegion getRepoClassInstance(string $repoType = null)
 */
#[LazyLoadRepo(LazyLoadRepo::DB, repoClass: DBPoliticalRegion::class)]
#[RolesRequiredForUpdate(Role::ADMIN)]
class PoliticalRegion extends Entity
{
    use TranslatableTrait, QueryOptionsTrait;

    /** @var string Stable region identifier */
    #[DatabaseIndex(indexType: DatabaseIndex::TYPE_UNIQUE)]
    #[Length(max: 64)]
    public string $slug;

    /** @var string Short code (e.g. EU, AM-NA, EU-EU) */
    #[DatabaseIndex(indexType: DatabaseIndex::TYPE_UNIQUE)]
    #[Length(max: 8)]
    public string $shortCode;

    /** @var string|null UN M49 numeric code */
    #[Length(max: 3)]
    public ?string $numericCode = null;

    /** @var int|null Parent political region ID (null for top-level regions) */
    public ?int $parentPoliticalRegionId = null;

    /** @var PoliticalRegion|null Parent political region */
    #[LazyLoad(addAsParent: true)]
    public ?PoliticalRegion $parentPoliticalRegion = null;

    /** @var string|null Region name (multilingual) */
    #[Translatable(fullTextIndex: true)]
    public ?string $name = null;

    /** @var int Display order for UI sorting */
    public int $displayOrder = 0;

    /** @var bool Whether this region is currently active */
    public bool $isActive = true;

    /** @var PoliticalRegions|null Child sub-regions */
    #[LazyLoad]
    public ?PoliticalRegions $childPoliticalRegions = null;

    /** @var Countries|null Countries assigned to this region */
    #[LazyLoad]
    public ?Countries $countries = null;

    public function uniqueKey(): string
    {
        $key = $this->id ?? $this->slug ?? spl_object_id($this);
        return self::uniqueKeyStatic($key);
    }
}
