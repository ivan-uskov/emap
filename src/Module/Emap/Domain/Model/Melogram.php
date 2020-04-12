<?php

namespace App\Module\Emap\Domain\Model;

class Melogram implements HierarchyElementInterface
{
    private int $id;
    private string $uid;

    private int $item;
    private int $family;
    private int $colony;
    private int $population;
    private int $specie;

    private string $file;

    public function __construct(int $id, string $uid, int $item, int $family, int $colony, int $population, int $specie, string $file)
    {
        $this->id = $id;
        $this->uid = $uid;
        $this->item = $item;
        $this->family = $family;
        $this->colony = $colony;
        $this->population = $population;
        $this->specie = $specie;
        $this->file = $file;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUid(): string
    {
        return $this->uid;
    }

    public function getItem(): int
    {
        return $this->item;
    }

    public function getFamily(): int
    {
        return $this->family;
    }

    public function getColony(): int
    {
        return $this->colony;
    }

    public function getPopulation(): int
    {
        return $this->population;
    }

    public function getSpecie(): int
    {
        return $this->specie;
    }

    public function getFile(): string
    {
        return $this->file;
    }

    public function setUid(string $uid): void
    {
        $this->uid = $uid;
    }

    public function setItem(int $item): void
    {
        $this->item = $item;
    }

    public function setFamily(int $family): void
    {
        $this->family = $family;
    }

    public function setColony(int $colony): void
    {
        $this->colony = $colony;
    }

    public function setPopulation(int $population): void
    {
        $this->population = $population;
    }

    public function setSpecie(int $specie): void
    {
        $this->specie = $specie;
    }

    public function setFile(string $file): void
    {
        $this->file = $file;
    }
}