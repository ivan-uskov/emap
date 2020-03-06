<?php

namespace App\Module\Emap\App\Service\Data;

class HierarchyVariantData
{
    private int $familyId;
    private string $familyName;
    private string $colonyName;
    private string $populationName;
    private string $specieName;

    public function __construct(int $familyId, string $familyName, string $colonyName, string $populationName, string $specieName)
    {
        $this->familyId = $familyId;
        $this->familyName = $familyName;
        $this->colonyName = $colonyName;
        $this->populationName = $populationName;
        $this->specieName = $specieName;
    }

    public function getFamilyId(): int
    {
        return $this->familyId;
    }

    public function getFamilyName(): string
    {
        return $this->familyName;
    }

    public function getColonyName(): string
    {
        return $this->colonyName;
    }

    public function getPopulationName(): string
    {
        return $this->populationName;
    }

    public function getSpecieName(): string
    {
        return $this->specieName;
    }
}