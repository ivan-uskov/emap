<?php

namespace App\Module\Emap\Api\Output;

use App\Module\Emap\App\Service\Data\SelectionGroupData;

class SelectionGroupOutput
{
    private SelectionGroupData $data;

    public function __construct(SelectionGroupData $data)
    {
        $this->data = $data;
    }
}