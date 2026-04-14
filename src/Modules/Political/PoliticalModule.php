<?php

declare(strict_types=1);

namespace DDD\Modules\Political;

use DDD\Infrastructure\Modules\DDDModule;

class PoliticalModule extends DDDModule
{
    public static function getSourcePath(): string
    {
        return __DIR__ . '/../..';
    }

    public static function getConfigPath(): ?string
    {
        return __DIR__ . '/../../../config/app';
    }

    public static function getPublicServiceNamespaces(): array
    {
        return [
            'DDD\\Domain\\Common\\Services\\PoliticalEntities\\',
            'DDD\\Domain\\Common\\Services\\Languages\\',
        ];
    }
}
