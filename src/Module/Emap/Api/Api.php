<?php

namespace App\Module\Emap\Api;

use App\Entity\Melogram;
use App\Module\Emap\Api\Output\MelogramsListOutput;
use App\Module\Emap\Infrastructure\Persistence\Doctrine\MelogramQueryService;
use Doctrine\Persistence\ManagerRegistry;

class Api implements ApiInterface
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getMelogramsList(): MelogramsListOutput
    {
        $qs = new MelogramQueryService($this->doctrine->getRepository(Melogram::class));
        return new MelogramsListOutput($qs->getAllMelograms());
    }
}