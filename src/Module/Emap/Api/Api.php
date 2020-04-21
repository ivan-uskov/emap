<?php

namespace App\Module\Emap\Api;

use App\Module\Emap\Api\Input\AddMelogramInput;
use App\Module\Emap\Api\Input\UpdateMelogramInput;
use App\Module\Emap\Api\Output\MelogramOutput;
use App\Module\Emap\Api\Output\MelogramsListOutput;
use App\Module\Emap\Api\Output\SelectionGroupListOutput;
use App\Module\Emap\Api\Output\SelectionGroupOutput;
use App\Module\Emap\Api\Output\SelectionOutput;
use App\Module\Emap\Api\Output\SelectionsListOutput;
use App\Module\Emap\App\Command\AddMelogramCommand;
use App\Module\Emap\App\Command\AddSelectionCommand;
use App\Module\Emap\App\Command\Handler\AddMelogramCommandHandler;
use App\Module\Emap\App\Command\Handler\AddSelectionCommandHandler;
use App\Module\Emap\App\Command\Handler\UpdateMelogramCommandHandler;
use App\Module\Emap\App\Command\UpdateMelogramCommand;
use App\Module\Emap\App\Service\Data\MelogramData;
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

    public function getMelogramHierarchyData(int $melogramId) : ?MelogramData
    {
        $qs = new MelogramQueryService($this->manager);
        return $qs->getMelogram($melogramId);
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
            $input->getFile(),
            $input->getFileName()
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
            $input->getFile(),
            $input->getFileName()
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

    public function removeSelection(int $id): void
    {
        $this->selectionService->removeSelection($id);
    }

    public function getSelections(): SelectionsListOutput
    {
        $qs = new SelectionQueryService($this->manager);
        return new SelectionsListOutput($qs->getSelections());
    }

    public function getSelection(int $id): ?SelectionOutput
    {
        $qs = new SelectionQueryService($this->manager);
        $data = $qs->getSelection($id);
        if ($data === null)
        {
            return null;
        }

        return new SelectionOutput($qs->getSelection($id));
    }

    public function addSelectionGroup(array $ids): void
    {
        // TODO: Implement addSelectionGroup() method.
    }

    public function removeSelectionGroup(int $id): void
    {
        // TODO: Implement removeSelectionGroup() method.
    }

    public function getSelectionGroups(): SelectionGroupListOutput
    {
        // TODO: Implement getSelectionGroups() method.
    }

    public function getSelectionGroup(int $id): ?SelectionGroupOutput
    {
        // TODO: Implement getSelectionGroup() method.
    }
}