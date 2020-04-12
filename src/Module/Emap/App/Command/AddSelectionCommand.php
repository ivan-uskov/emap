<?php

namespace App\Module\Emap\App\Command;

class AddSelectionCommand
{
    private array $uids;

    public function __construct(array $uids)
    {
        $this->uids = $uids;
    }

    public function getUids(): array
    {
        return $this->uids;
    }
}