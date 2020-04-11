<?php

namespace App\Module\Emap\Api;

use App\Module\Emap\Api\Input\AddMelogramInput;
use App\Module\Emap\Api\Input\UpdateMelogramInput;
use App\Module\Emap\Api\Output\HierarchyVariantsListOutput;
use App\Module\Emap\Api\Output\MelogramOutput;
use App\Module\Emap\Api\Output\MelogramsListOutput;

interface ApiInterface
{
    public function getMelogram(int $melogramId): ?MelogramOutput;
    public function getMelogramsList(): MelogramsListOutput;
    public function getMelogramsByHierarchy(int $itemId, int $familyId, int $colonyId, int $populationId, int $specieId): MelogramsListOutput;
    public function addMelogram(AddMelogramInput $input): void;
    public function updateMelogram(UpdateMelogramInput $input): void;
    public function removeMelogram(int $id): void;

    public function getNoteList(): array;

    public function getHierarchyVariantsList(): HierarchyVariantsListOutput;
}