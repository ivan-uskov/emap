<?php

namespace App\Module\Emap\Api\Input;

class AddMelogramInput
{
    private string $name;
    private int $familyId;
    private string $file;

    public function __construct(string $name,  int $familyId, string $file)
    {
        $this->name = $name;
        $this->familyId = $familyId;
        $this->file = $file;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFamilyId(): int
    {
        return $this->familyId;
    }

    public function getFile(): string
    {
        return $this->file;
    }
}