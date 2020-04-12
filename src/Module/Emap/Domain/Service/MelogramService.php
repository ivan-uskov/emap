<?php

namespace App\Module\Emap\Domain\Service;

use App\Module\Emap\Domain\Exception\DuplicateMelogramException;
use App\Module\Emap\Domain\Exception\EmptyMelogramFileException;
use App\Module\Emap\Domain\Exception\InvalidFamilyIdException;
use App\Module\Emap\Domain\Exception\MelogramNotExistsException;
use App\Module\Emap\Domain\Model\Melogram;
use App\Module\Emap\Domain\Model\MelogramRepositoryInterface;
use App\Module\Emap\Domain\Model\MelogramSpecification;

class MelogramService
{
    private MelogramRepositoryInterface $repository;

    public function __construct(MelogramRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function removeMelogram(int $id): void
    {
        $this->repository->removeMelogram($id);
    }

    /**
     * @param MelogramSpecification $specification
     * @throws EmptyMelogramFileException
     * @throws DuplicateMelogramException
     * @throws InvalidFamilyIdException
     */
    public function addMelogram(MelogramSpecification $specification): void
    {
        if (empty($specification->getFile()))
        {
            throw new EmptyMelogramFileException('');
        }

        if ($this->repository->hasMelogram($specification->getUid()))
        {
            throw new DuplicateMelogramException('');
        }
        $this->repository->addMelogram($specification);
    }

    /**
     * @param int $id
     * @param MelogramSpecification $specification
     * @throws DuplicateMelogramException
     * @throws InvalidFamilyIdException
     * @throws MelogramNotExistsException
     */
    public function updateMelogram(int $id, MelogramSpecification $specification): void
    {
        $melogram = $this->repository->getMelogram($id);
        if ($melogram === null)
        {
            throw new MelogramNotExistsException('');
        }

        if (($melogram->getUid() !== $specification->getUid()) && $this->repository->hasMelogram($specification->getUid()))
        {
            throw new DuplicateMelogramException('');
        }

        if ($specification->getFile() !== '')
        {
            $melogram->setFile($melogram->getFile());
        }

        $melogram->setUid($specification->getUid());
        $melogram->setItem($specification->getItem());
        $melogram->setFamily($specification->getFamily());
        $melogram->setColony($specification->getColony());
        $melogram->setPopulation($specification->getPopulation());
        $melogram->setSpecie($specification->getSpecie());

        $this->repository->updateMelogram($melogram);
    }
}