<?php

namespace App\Module\Emap\App\Service\Data;

class MelogramData
{
    private int $id;
    private string $name;

    private ?string $family;
    private ?string $colony;
    private ?string $population;
    private ?string $specie;
    private ?array $attributes;

    public function __construct(int $id, string $name, ?string $family, ?string $colony, ?string $population, ?string $specie, ?array $attributes)
    {
        $this->id = $id;
        $this->name = $name;
        $this->family = $family;
        $this->colony = $colony;
        $this->population = $population;
        $this->specie = $specie;
        $this->attributes = $attributes;
    }

    public function asArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'family' => $this->family,
            'colony' => $this->colony,
            'population' => $this->population,
            'specie' => $this->specie,
            'attributes' => $this->attributes,
        ];
    }
}