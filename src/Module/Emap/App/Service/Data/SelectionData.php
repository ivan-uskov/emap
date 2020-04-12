<?php

namespace App\Module\Emap\App\Service\Data;

class SelectionData
{
    private int $id;
    private string $hash;
    private array $uids;

    public function __construct(int $id, string $hash, array $uids)
    {
        $this->id = $id;
        $this->hash = $hash;
        $this->uids = $uids;
    }

    public function getId(): int
    {
        return $this->id;
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