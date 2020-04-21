<?php

namespace App\Module\Emap\Api\Output;

use App\Module\Emap\App\Service\Data\SelectionData;

class SelectionOutput
{
    private SelectionData $data;

    public function __construct(SelectionData $data)
    {
        $this->data = $data;
    }

    public function getId(): int
    {
        return $this->data->getId();
    }

    public function getUidsWithFiles(): array
    {
        return $this->data->getUidsWithFiles();
    }
}