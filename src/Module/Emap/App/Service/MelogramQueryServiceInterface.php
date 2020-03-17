<?php

namespace App\Module\Emap\App\Service;

use App\Module\Emap\App\Service\Data\HierarchyVariantData;
use App\Module\Emap\App\Service\Data\MelogramData;

interface MelogramQueryServiceInterface
{
    public function getMelogram(int $id): ?MelogramData;
    /**
     * @return MelogramData[]
     */
    public function getAllMelograms(): array;

    /**
     * @return HierarchyVariantData[]
     */
    public function getHierarchyVariants(): array;
}