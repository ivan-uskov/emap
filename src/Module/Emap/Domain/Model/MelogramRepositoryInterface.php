<?php

namespace App\Module\Emap\Domain\Model;

interface MelogramRepositoryInterface
{
    public function addMelogram(MelogramSpecification $m): void;
    public function updateMelogram(Melogram $m): void;
    public function removeMelogram(int $id): void;

    public function hasMelogram(string $uid): bool;
    public function getMelogram(int $id): Melogram;
}