<?php

namespace App\Module\Emap\App\Command;

class AddMelogramCommand
{
    private int $item;
    private int $family;
    private int $colony;
    private int $population;
    private int $specie;

    private string $file;

    public function __construct(
        int $item,
        int $family,
        int $colony,
        int $population,
        int $specie,
        string $file,
        string $fileName
    ) {
        $this->item = $item;
        $this->family = $family;
        $this->colony = $colony;
        $this->population = $population;
        $this->specie = $specie;

        $this->file = $file;
        $this->fileName = $fileName;
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

    public function getFileName(): string
    {
        return $this->fileName;
    }
}