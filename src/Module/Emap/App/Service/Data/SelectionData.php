<?php

namespace App\Module\Emap\App\Service\Data;

class SelectionData
{
    private int $id;
    private string $date;
    private array $uidsWithFiles;

    public function __construct(int $id, string $date, array $uidsWithFiles)
    {
        $this->id = $id;
        $this->date = $date;
        $this->uidsWithFiles = $uidsWithFiles;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getUids(): array
    {
        return array_keys($this->uidsWithFiles);
    }

    public function getUidsWithFiles(): array
    {
        return $this->uidsWithFiles;
    }
}