<?php

namespace App\Module\Emap\App\Service\Data;

class SelectionData
{
    private int $id;
    private string $hash;
    private string $date;
    private array $uids;

    public function __construct(int $id, string $hash, string $date, array $uids)
    {
        $this->id = $id;
        $this->hash = $hash;
        $this->date = $date;
        $this->uids = $uids;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getUids(): array
    {
        return $this->uids;
    }
}