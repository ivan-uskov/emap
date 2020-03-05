<?php

namespace App\Module\Emap\Domain\Model;

interface MelogramRepositoryInterface
{
    public function addMelogram(Melogram $m): void;
}