<?php

namespace App\Module\Emap\App\Command\Handler;

use App\Module\Emap\App\Command\AddMelogramCommand;
use App\Module\Emap\Domain\Model\MelogramSpecification;
use App\Module\Emap\Domain\Service\MelogramService;

class AddMelogramCommandHandler
{
    private MelogramService $service;

    public function __construct(MelogramService $service)
    {
        $this->service = $service;
    }

    public function handle(AddMelogramCommand $command): void
    {
        $m = new MelogramSpecification(
            $command->getItem(),
            $command->getFamily(),
            $command->getColony(),
            $command->getPopulation(),
            $command->getSpecie(),
            $command->getFile(),
            $command->getFileName()
        );
        var_dump($m);
        $this->service->addMelogram($m);
    }
}