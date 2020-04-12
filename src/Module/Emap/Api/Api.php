<?php

namespace App\Module\Emap\Api;

use App\Module\Emap\Api\Input\AddMelogramInput;
use App\Module\Emap\Api\Input\UpdateMelogramInput;
use App\Module\Emap\Api\Output\MelogramOutput;
use App\Module\Emap\Api\Output\MelogramsListOutput;
use App\Module\Emap\Api\Output\SelectionsListOutput;
use App\Module\Emap\App\Command\AddMelogramCommand;
use App\Module\Emap\App\Command\AddSelectionCommand;
use App\Module\Emap\App\Command\Handler\AddMelogramCommandHandler;
use App\Module\Emap\App\Command\Handler\AddSelectionCommandHandler;
use App\Module\Emap\App\Command\Handler\UpdateMelogramCommandHandler;
use App\Module\Emap\App\Command\UpdateMelogramCommand;
use App\Module\Emap\Domain\Service\MelogramService;
use App\Module\Emap\Domain\Service\SelectionService;
use App\Module\Emap\Infrastructure\Persistence\Doctrine\MelogramQueryService;
use App\Module\Emap\Infrastructure\Persistence\Doctrine\MelogramRepository;
use App\Module\Emap\Infrastructure\Persistence\Doctrine\SelectionQueryService;
use App\Module\Emap\Infrastructure\Persistence\Doctrine\SelectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class Api implements ApiInterface
{
    private EntityManagerInterface $manager;
    private MelogramService $melogramService;
    private SelectionService $selectionService;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->manager = $doctrine->getManager();
        $this->melogramService = new MelogramService(new MelogramRepository($this->manager));
        $this->selectionService = new SelectionService(new SelectionRepository($this->manager));
    }

    public function getMelogram(int $melogramId): ?MelogramOutput
    {
        $qs = new MelogramQueryService($this->manager);
        return new MelogramOutput($qs->getMelogram($melogramId));
    }

    public function getMelogramsList(): MelogramsListOutput
    {
        $qs = new MelogramQueryService($this->manager);
        return new MelogramsListOutput($qs->getAllMelograms());
    }

    public function getMelogramsByHierarchy(int $itemId, int $familyId, int $colonyId, int $populationId, int $specieId): MelogramsListOutput
    {
        $qs = new MelogramQueryService($this->manager);
        return new MelogramsListOutput($qs->getMelogramsByHierarchy($itemId, $familyId
            , $colonyId, $populationId, $specieId));
    }

    public function addMelogram(AddMelogramInput $input): void
    {
        $handler = new AddMelogramCommandHandler($this->melogramService);
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
        $handler = new UpdateMelogramCommandHandler($this->melogramService);
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
        $this->melogramService->removeMelogram($id);
    }

    public function addSelection(array $uids): void
    {
        $handler = new AddSelectionCommandHandler($this->selectionService);
        $handler->handle(new AddSelectionCommand($uids));
    }

    public function getSelections(): SelectionsListOutput
    {
        $qs = new SelectionQueryService($this->manager);
        return new SelectionsListOutput($qs->getSelections());
    }
}