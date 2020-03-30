<?php

namespace App\Module\Emap\Domain\Model;

interface MelogramRepositoryInterface
{
    public function addMelogram(Melogram $m): void;
    public function updateMelogram(Melogram $m): void;
    public function removeMelogram(int $id): void;

    public function hasFamily(int $familyId): bool;
    public function hasMelogram(string $specie, string $population, string $colony, string $family
        , string $item): bool;
    public function getMelogram(int $id): Melogram;
}