<?php

namespace App\Module\Emap\Api;

use App\Module\Emap\Api\Input\AddMelogramInput;
use App\Module\Emap\Api\Output\MelogramsListOutput;
use App\Module\Emap\App\Command\AddMelogramCommand;
use App\Module\Emap\App\Command\Handler\AddMelogramCommandHandler;
use App\Module\Emap\Domain\Service\MelogramService;
use App\Module\Emap\Infrastructure\Persistence\Doctrine\MelogramQueryService;
use App\Module\Emap\Infrastructure\Persistence\Doctrine\MelogramRepository;
use Doctrine\Persistence\ManagerRegistry;

class Api implements ApiInterface
{
    private ManagerRegistry $doctrine;
    private MelogramService $service;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->service = new MelogramService(new MelogramRepository($doctrine->getManager()));
    }

    public function getMelogramsList(): MelogramsListOutput
    {
        $qs = new MelogramQueryService($this->doctrine->getManager());
        return new MelogramsListOutput($qs->getAllMelograms());
    }

    public function addMelogram(AddMelogramInput $input): void
    {
        $handler = new AddMelogramCommandHandler($this->service);
        $handler->handle(new AddMelogramCommand($input->getName()));
    }
}