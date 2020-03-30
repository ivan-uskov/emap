<?php

namespace App\Module\Emap\App\Command;

class AddMelogramCommand
{
    private string $name;
    private int $itemId;
    private int $familyId;
    private int $colonyId;
    private int $populationId;
    private int $specieId;

    private string $file;

    public function __construct(string $name, int $itemId, int $familyId, int $colonyId
        , int $populationId, int $specieId, string $file)
    {
        $this->name = $name;

        $this->itemId = $itemId;
        $this->familyId = $familyId;
        $this->colonyId = $colonyId;
        $this->populationId = $populationId;
        $this->specieId = $specieId;

        $this->file = $file;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getItemId(): int
    {
        return $this->itemId;
    }

    public function getFamilyId(): int
    {
        return $this->familyId;
    }

    public function getColonyId(): int
    {
        return $this->colonyId;
    }

    public function getPopulationId(): int
    {
        return $this->populationId;
    }

    public function getSpecieId(): int
    {
        return $this->specieId;
    }

    public function getFile(): string
    {
        return $this->file;
    }
}