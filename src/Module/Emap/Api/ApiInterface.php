<?php

namespace App\Module\Emap\Api;

use App\Module\Emap\Api\Input\AddMelogramInput;
use App\Module\Emap\Api\Output\HierarchyVariantsListOutput;
use App\Module\Emap\Api\Output\MelogramsListOutput;

interface ApiInterface
{
    public function getMelogramsList(): MelogramsListOutput;
    public function addMelogram(AddMelogramInput $input): void;

    public function getHierarchyVariantsList(): HierarchyVariantsListOutput;
}