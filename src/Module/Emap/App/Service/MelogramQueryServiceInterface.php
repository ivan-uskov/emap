<?php

namespace App\Module\Emap\App\Service;

use App\Module\Emap\App\Service\Data\MelogramData;

interface MelogramQueryServiceInterface
{
    public function getMelogram(int $id): ?MelogramData;
    /**
     * @return MelogramData[]
     */
    public function getAllMelograms(): array;

    public function getMelogramsByHierarchy(int $item, int $family
        , int $colony, int $population, int $specie): array;
}