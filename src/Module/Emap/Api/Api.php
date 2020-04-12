<?php

namespace App\Module\Emap\Api;

use App\Module\Emap\Api\Input\AddMelogramInput;
use App\Module\Emap\Api\Input\UpdateMelogramInput;
use App\Module\Emap\Api\Output\MelogramOutput;
use App\Module\Emap\Api\Output\MelogramsListOutput;
use App\Module\Emap\App\Command\AddMelogramCommand;
use App\Module\Emap\App\Command\Handler\AddMelogramCommandHandler;
use App\Module\Emap\App\Command\Handler\UpdateMelogramCommandHandler;
use App\Module\Emap\App\Command\UpdateMelogramCommand;
use App\Module\Emap\Domain\Service\MelogramParser;
use App\Module\Emap\Domain\Service\MelogramService;
use App\Module\Emap\Infrastructure\Persistence\Doctrine\MelogramQueryService;
use App\Module\Emap\Infrastructure\Persistence\Doctrine\MelogramRepository;
use Doctrine\Persistence\ManagerRegistry;

class Api implements ApiInterface
{
    private ManagerRegistry $doctrine;
    private MelogramService $service;
    private MelogramParser $parser;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->service = new MelogramService(new MelogramRepository($doctrine->getManager()));
        $this->parser = new MelogramParser();
    }

    public function getMelogram(int $melogramId): ?MelogramOutput
    {
        $qs = new MelogramQueryService($this->doctrine->getManager());
        return new MelogramOutput($qs->getMelogram($melogramId));
    }

    public function getNoteList(): array {
        return $this->parser->getMelogramArray();
    }

    public function getMelogramsList(): MelogramsListOutput
    {
        $qs = new MelogramQueryService($this->doctrine->getManager());
        return new MelogramsListOutput($qs->getAllMelograms());
    }

    public function getMelogramsByHierarchy(int $itemId, int $familyId, int $colonyId, int $populationId, int $specieId): MelogramsListOutput
    {
        $qs = new MelogramQueryService($this->doctrine->getManager());
        return new MelogramsListOutput($qs->getMelogramsByHierarchy($itemId, $familyId
            , $colonyId, $populationId, $specieId));
    }

    public function addMelogram(AddMelogramInput $input): void
    {
        $handler = new AddMelogramCommandHandler($this->service);
        $handler->handle(new AddMelogramCommand(
            $input->getItem(),
            $input->getFamily(),
            $input->getColony(),
            $input->getPopulation(),
            $input->getSpecie(),
            $input->getFile()
        ));
    }

    public function updateMelogram(UpdateMelogramInput $input): void
    {
        $handler = new UpdateMelogramCommandHandler($this->service);
        $handler->handle(new UpdateMelogramCommand(
            $input->getId(),
            $input->getItem(),
            $input->getFamily(),
            $input->getColony(),
            $input->getPopulation(),
            $input->getSpecie(),
            $input->getFile()
        ));
    }

    public function removeMelogram(int $id): void
    {
        $this->service->removeMelogram($id);
    }
}