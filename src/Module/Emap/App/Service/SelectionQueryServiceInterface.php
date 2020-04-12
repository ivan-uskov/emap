<?php

namespace App\Module\Emap\App\Service;

use App\Module\Emap\App\Service\Data\SelectionData;

interface SelectionQueryServiceInterface
{
    /**
     * @return SelectionData[]
     */
    public function getSelections(): array;
}