<?php

namespace App\Module\Emap\Domain\Service;

use App\Module\Emap\Domain\Exception\DuplicateMelogramNameException;
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

    public function addMelogram(Melogram $melogram): void
    {
        if ($melogram->getName() === '')
        {
            throw new EmptyMelogramNameException();
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