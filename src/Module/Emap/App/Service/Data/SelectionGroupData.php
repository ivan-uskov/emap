<?php

namespace App\Module\Emap\App\Service\Data;

class SelectionGroupData
{
    private int $id;
    private string $date;
    private array $ids;

    public function __construct(int $id, string $date, array $ids)
    {
        $this->id = $id;
        $this->date = $date;
        $this->ids = $ids;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getIds(): array
    {
        return $this->ids;
    }
}