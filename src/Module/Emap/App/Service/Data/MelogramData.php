<?php

namespace App\Module\Emap\App\Service\Data;

class MelogramData
{
    private int $id;
    private string $name;
    private string $file;

    private ?int $familyId;
    private ?string $family;
    private ?string $colony;
    private ?string $population;
    private ?string $specie;
    private ?array $attributes;

    public function __construct(int $id, string $name, string $file, ?int $familyId, ?string $family, ?string $colony, ?string $population, ?string $specie, ?array $attributes)
    {
        $this->id = $id;
        $this->name = $name;
        $this->file = $file;
        $this->familyId = $familyId;
        $this->family = $family;
        $this->colony = $colony;
        $this->population = $population;
        $this->specie = $specie;
        $this->attributes = $attributes;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFile(): string
    {
        return $this->file;
    }

    public function getFamilyId(): ?int
    {
        return $this->familyId;
    }

    public function getFamily(): ?string
    {
        return $this->family;
    }

    public function getColony(): ?string
    {
        return $this->colony;
    }

    public function getPopulation(): ?string
    {
        return $this->population;
    }

    public function getSpecie(): ?string
    {
        return $this->specie;
    }

    public function getAttributes(): ?array
    {
        return $this->attributes;
    }

    public function asArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'file' => $this->file,
            'familyId' => $this->familyId,
            'family' => $this->family,
            'colony' => $this->colony,
            'population' => $this->population,
            'specie' => $this->specie,
            'attributes' => $this->attributes,
            'uid' => implode('.', [$this->specie, $this->population, $this->colony, $this->family, $this->name]),
        ];
    }
}