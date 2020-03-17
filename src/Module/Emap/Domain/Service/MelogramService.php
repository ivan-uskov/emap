<?php

namespace App\Module\Emap\Domain\Service;

use App\Module\Emap\Domain\Exception\DuplicateMelogramNameException;
use App\Module\Emap\Domain\Exception\EmptyMelogramFileException;
use App\Module\Emap\Domain\Exception\EmptyMelogramNameException;
use App\Module\Emap\Domain\Exception\InvalidFamilyIdException;
use App\Module\Emap\Domain\Exception\MelogramNotExistsException;
use App\Module\Emap\Domain\Model\Melogram;
use App\Module\Emap\Domain\Model\MelogramRepositoryInterface;

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
     * @param Melogram $melogram
     * @throws EmptyMelogramFileException
     * @throws EmptyMelogramNameException
     * @throws DuplicateMelogramNameException
     * @throws InvalidFamilyIdException
     */
    public function addMelogram(Melogram $melogram): void
    {
        if ($melogram->getName() === '')
        {
            throw new EmptyMelogramNameException();
        }

        if (empty($melogram->getFile()))
        {
            throw new EmptyMelogramFileException();
        }

        if ($this->repository->hasMelogram($melogram->getName()))
        {
            throw new DuplicateMelogramNameException();
        }

        if (!$this->repository->hasFamily($melogram->getFamilyId()))
        {
            throw new InvalidFamilyIdException();
        }

        $this->repository->addMelogram($melogram);
    }

    /**
     * @param Melogram $melogram
     * @throws DuplicateMelogramNameException
     * @throws InvalidFamilyIdException
     * @throws MelogramNotExistsException
     */
    public function updateMelogram(Melogram $melogram): void
    {
        $oldMelogram = $this->repository->getMelogram($melogram->getId());
        if ($oldMelogram === null)
        {
            throw new MelogramNotExistsException();
        }

        if (($oldMelogram->getName() !== $melogram->getName()) && $this->repository->hasMelogram($melogram->getName()))
        {
            throw new DuplicateMelogramNameException();
        }

        if (!$this->repository->hasFamily($melogram->getFamilyId()))
        {
            throw new InvalidFamilyIdException();
        }

        if ($melogram->getFile() === '')
        {
            $melogram->setFile($oldMelogram->getFile());
        }

        $this->repository->updateMelogram($melogram);
    }
}