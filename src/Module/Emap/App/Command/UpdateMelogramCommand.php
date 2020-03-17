<?php

namespace App\Module\Emap\App\Command;

class UpdateMelogramCommand
{
    private int $id;
    private string $name;
    private int $familyId;
    private ?string $file;

    public function __construct(int $id, string $name,  int $familyId, ?string $file)
    {
        $this->id = $id;
        $this->name = $name;
        $this->familyId = $familyId;
        $this->file = $file;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFamilyId(): int
    {
        return $this->familyId;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }
}