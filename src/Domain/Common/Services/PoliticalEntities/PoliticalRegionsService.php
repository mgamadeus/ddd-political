<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Services\PoliticalEntities;

use DDD\Domain\Common\Entities\PoliticalEntities\PoliticalRegions\PoliticalRegion;
use DDD\Domain\Common\Entities\PoliticalEntities\PoliticalRegions\PoliticalRegions;
use DDD\Domain\Common\Repo\DB\PoliticalEntities\PoliticalRegions\DBPoliticalRegion;
use DDD\Domain\Common\Repo\DB\PoliticalEntities\PoliticalRegions\DBPoliticalRegions;

use DDD\Domain\Base\Entities\Entity;
use DDD\Domain\Base\Services\EntitiesService;
use DDD\Infrastructure\Libs\Config;

/**
 * @method PoliticalRegion find(int|string|null $entityId, bool $useEntityRegistrCache = true)
 * @method PoliticalRegions findAll(?int $offset = null, $limit = null, bool $useEntityRegistrCache = true)
 * @method PoliticalRegion update(Entity $entity)
 * @method DBPoliticalRegion getEntityRepoClassInstance()
 * @method DBPoliticalRegions getEntitySetRepoClassInstance()
 */
class PoliticalRegionsService extends EntitiesService
{
    public const DEFAULT_ENTITY_CLASS = PoliticalRegion::class;

    /**
     * Find a political region by its stable slug
     */
    public function findBySlug(string $slug): ?PoliticalRegion
    {
        $repoClass = $this->getEntityRepoClassInstance();
        $queryBuilder = $repoClass::createQueryBuilder();
        $baseModelAlias = $repoClass::getBaseModelAlias();
        $queryBuilder->andWhere("{$baseModelAlias}.slug = :slug");
        $queryBuilder->setParameter('slug', $slug);

        return $repoClass->find($queryBuilder);
    }

    /**
     * Imports all political regions from config/app/Common/PoliticalRegions.php.
     * Top-level regions (parentSlug = null) are imported first, then children,
     * so parent IDs can be resolved.
     */
    public function importPoliticalRegionsFromConfig(): PoliticalRegions
    {
        $importedPoliticalRegions = new PoliticalRegions();

        $config = Config::get('Common.PoliticalRegions.politicalRegions');
        if (!is_array($config) || empty($config)) {
            return $importedPoliticalRegions;
        }

        // Split into top-level and children so parents exist before children reference them
        $topLevel = [];
        $children = [];
        foreach ($config as $key => $data) {
            if (($data['parentSlug'] ?? null) === null) {
                $topLevel[$key] = $data;
            } else {
                $children[$key] = $data;
            }
        }

        // Pass 1: top-level regions
        foreach ($topLevel as $data) {
            $singleResult = $this->importSingleRegion($data, null);
            if ($singleResult !== null) {
                $importedPoliticalRegions->add($singleResult['region']);
            }
        }

        // Pass 2: child regions (resolve parentSlug)
        foreach ($children as $data) {
            $parentSlug = $data['parentSlug'];
            $parent = $this->findBySlug($parentSlug);
            $parentId = $parent?->id;

            $singleResult = $this->importSingleRegion($data, $parentId);
            if ($singleResult !== null) {
                $importedPoliticalRegions->add($singleResult['region']);
            }
        }

        return $importedPoliticalRegions;
    }

    /**
     * Imports or updates a single political region.
     *
     * @return array{region: PoliticalRegion, isNew: bool}|null
     */
    protected function importSingleRegion(array $data, ?int $parentId): ?array
    {
        $slug = $data['slug'] ?? null;
        if ($slug === null) {
            return null;
        }

        $nameData = $data['name'] ?? null;
        $nameValue = is_array($nameData) ? ($nameData['en'] ?? null) : ($nameData ?? null);

        $existing = $this->findBySlug($slug);

        if ($existing !== null) {
            $existing->shortCode = $data['shortCode'] ?? $existing->shortCode;
            $existing->numericCode = $data['numericCode'] ?? $existing->numericCode;
            $existing->parentPoliticalRegionId = $parentId ?? $existing->parentPoliticalRegionId;
            $existing->name = $nameValue ?? $existing->name;
            $existing->displayOrder = $data['displayOrder'] ?? $existing->displayOrder;
            $existing->isActive = $data['isActive'] ?? $existing->isActive;
            $this->applyNameTranslations($existing, $nameData);

            $saved = $this->update($existing);
            return ['region' => $saved, 'isNew' => false];
        }

        $region = new PoliticalRegion();
        $region->slug = $slug;
        $region->shortCode = $data['shortCode'];
        $region->numericCode = $data['numericCode'] ?? null;
        $region->parentPoliticalRegionId = $parentId;
        $region->name = $nameValue;
        $region->displayOrder = $data['displayOrder'] ?? 0;
        $region->isActive = $data['isActive'] ?? true;
        $this->applyNameTranslations($region, $nameData);

        $saved = $this->update($region);
        return ['region' => $saved, 'isNew' => true];
    }

    /**
     * Sets translations for the name property from a config name array.
     */
    protected function applyNameTranslations(PoliticalRegion $region, array|string|null $nameData): void
    {
        if (!is_array($nameData)) {
            return;
        }
        foreach ($nameData as $langCode => $translatedName) {
            $region->setTranslationForProperty('name', $translatedName, $langCode);
        }
    }
}
