<?php

namespace App\Module\Emap\Infrastructure\Persistence\Doctrine;

use App\Entity\Melogram;
use App\Module\Emap\App\Service\Data\MelogramData;
use App\Module\Emap\App\Service\MelogramQueryServiceInterface;
use Doctrine\Persistence\ObjectRepository;

class MelogramQueryService implements MelogramQueryServiceInterface
{
    private ObjectRepository $melogramRepository;

    public function __construct(ObjectRepository $repository)
    {
        $this->melogramRepository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function getAllMelograms(): array
    {
        return array_map(fn(Melogram $m) => new MelogramData($m->getName()), $this->melogramRepository->findAll());
    }
}