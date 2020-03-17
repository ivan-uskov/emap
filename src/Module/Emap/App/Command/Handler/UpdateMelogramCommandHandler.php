<?php

namespace App\Module\Emap\App\Command\Handler;

use App\Module\Emap\App\Command\UpdateMelogramCommand;
use App\Module\Emap\Domain\Model\Melogram;
use App\Module\Emap\Domain\Service\MelogramService;

class UpdateMelogramCommandHandler
{
    private MelogramService $service;

    public function __construct(MelogramService $service)
    {
        $this->service = $service;
    }

    public function handle(UpdateMelogramCommand $command)
    {
        $this->service->updateMelogram(new Melogram($command->getId(), $command->getName(), $command->getFamilyId(), (string) $command->getFile()));
    }
}