<?php

namespace App\Module\Emap\Domain\Service;

use App\Module\Emap\Domain\Exception\DuplicateMelogramNameException;
use App\Module\Emap\Domain\Exception\EmptyMelogramFileException;
use App\Module\Emap\Domain\Exception\EmptyMelogramNameException;
use App\Module\Emap\Domain\Exception\InvalidFamilyIdException;
use App\Module\Emap\Domain\Model\Melogram;
use App\Module\Emap\Domain\Model\MelogramRepositoryInterface;

class MelogramService
{
    private MelogramRepositoryInterface $repository;

    public function __construct(MelogramRepositoryInterface $repository)
    {
        $this->repository = $repository;
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
}