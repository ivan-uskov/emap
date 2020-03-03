<?php

namespace App\Module\Emap\Api;

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
        $qs = new MelogramQueryService($this->doctrine->getManager());
        return new MelogramsListOutput($qs->getAllMelograms());
    }
}