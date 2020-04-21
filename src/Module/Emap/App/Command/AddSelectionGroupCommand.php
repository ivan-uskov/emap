<?php

namespace App\Module\Emap\App\Command;

class AddSelectionGroupCommand
{
    private array $ids;

    public function __construct(array $ids)
    {
        $this->ids = $ids;
    }

    public function getIds(): array
    {
        return $this->ids;
    }
}