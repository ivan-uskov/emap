<?php

namespace App\Module\Emap\App\Command\Handler;

use App\Module\Emap\App\Command\AddSelectionCommand;
use App\Module\Emap\Domain\Service\SelectionService;

class AddSelectionCommandHandler
{
    private SelectionService $service;

    public function __construct(SelectionService $service)
    {
        $this->service = $service;
    }

    public function handle(AddSelectionCommand $command): void
    {
        $this->service->add($command->getUids());
    }
}