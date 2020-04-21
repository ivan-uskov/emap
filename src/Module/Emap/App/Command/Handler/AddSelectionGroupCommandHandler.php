<?php

namespace App\Module\Emap\App\Command\Handler;

use App\Module\Emap\App\Command\AddSelectionGroupCommand;
use App\Module\Emap\Domain\Service\SelectionGroupService;

class AddSelectionGroupCommandHandler
{
    private SelectionGroupService $service;

    public function __construct(SelectionGroupService $service)
    {
        $this->service = $service;
    }

    public function handle(AddSelectionGroupCommand $command): void
    {
        $this->service->add($command->getIds());
    }
}