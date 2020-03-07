<?php

namespace App\Module\Emap\Domain\Model;

interface MelogramRepositoryInterface
{
    public function addMelogram(Melogram $m): void;
    public function removeMelogram(int $id): void;

    public function hasFamily(int $familyId): bool;
    public function hasMelogram(string $name): bool;
}