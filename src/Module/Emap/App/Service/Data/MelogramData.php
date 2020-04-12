<?php

namespace App\Module\Emap\App\Service\Data;

class MelogramData
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

    public function getUid(): string
    {
        return $this->uid;
    }

    public function getFile(): string
    {
        return $this->file;
    }

    public function asArray(): array
    {
        return [
            'id' => $this->id,
            'uid' => $this->uid,
            'file' => $this->file,
            'item' => $this->item,
            'family' => $this->family,
            'colony' => $this->colony,
            'population' => $this->population,
            'specie' => $this->specie,
        ];
    }
}