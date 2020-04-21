<?php

namespace App\Module\Emap\App\Service;

use App\Module\Emap\App\Service\Data\SelectionGroupData;

interface SelectionGroupQueryServiceInterface
{
    /** @return SelectionGroupData[] */
    public function getSelectionGroups(): array;
    public function getSelectionGroup(int $id): ?SelectionGroupData;
}