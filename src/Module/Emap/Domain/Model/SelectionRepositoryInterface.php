<?php

namespace App\Module\Emap\Domain\Model;

interface SelectionRepositoryInterface
{
    public function filterUids(array $uids): array;
    public function hasSelection(string $hash): bool;
    public function addSelection(string $hash, array $uids): void;
    public function removeSelection(int $id): void;
}