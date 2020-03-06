<?php

namespace App\Module\Emap\Api\Output;

use App\Module\Emap\App\Service\Data\HierarchyVariantData;

class HierarchyVariantsListOutput
{
    /**
     * @var HierarchyVariantData[]
     */
    private array $variants;

    public function __construct(array $variants)
    {
        $this->variants = $variants;
    }

    public function asAssoc(): array
    {
        $families = [];
        $colonies = [];
        $populations = [];
        $species = [];

        foreach ($this->variants as $variant)
        {
            $families[$variant->getFamilyId()] = $variant->getFamilyName();
            $colonies[$variant->getFamilyId()] = $variant->getColonyName();
            $populations[$variant->getFamilyId()] = $variant->getPopulationName();
            $species[$variant->getFamilyId()] = $variant->getSpecieName();
        }

        return [
            'families' => $families,
            'colonies' => $colonies,
            'populations' => $populations,
            'species' => $species,
        ];
    }
}