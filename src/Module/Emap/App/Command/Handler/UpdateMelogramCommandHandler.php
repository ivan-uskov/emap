<?php

namespace App\Module\Emap\App\Command\Handler;

use App\Module\Emap\App\Command\UpdateMelogramCommand;
use App\Module\Emap\Domain\Model\MelogramSpecification;
use App\Module\Emap\Domain\Service\MelogramService;

class UpdateMelogramCommandHandler
{
    private MelogramService $service;

    public function __construct(MelogramService $service)
    {
        $this->service = $service;
    }

    public function handle(UpdateMelogramCommand $command): void
    {
        $this->service->updateMelogram($command->getId(), new MelogramSpecification(
            $command->getItem(),
            $command->getFamily(),
            $command->getColony(),
            $command->getPopulation(),
            $command->getSpecie(),
            (string) $command->getFile(),
            $command->getFileName()
        ));
    }
}