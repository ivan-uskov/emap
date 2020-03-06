<?php

namespace App\Module\Emap\App\Command\Handler;

use App\Module\Emap\App\Command\AddMelogramCommand;
use App\Module\Emap\Domain\Model\Melogram;
use App\Module\Emap\Domain\Service\MelogramService;

class AddMelogramCommandHandler
{
    private MelogramService $service;

    public function __construct(MelogramService $service)
    {
        $this->service = $service;
    }

    public function handle(AddMelogramCommand $command)
    {
        $this->service->addMelogram(new Melogram($command->getName(), $command->getFamilyId(), $command->getFile()));
    }
}