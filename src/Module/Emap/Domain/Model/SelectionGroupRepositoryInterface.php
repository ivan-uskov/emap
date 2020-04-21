<?php

namespace App\Module\Emap\Domain\Model;

interface SelectionGroupRepositoryInterface
{
    public function filterIds(array $ids): array;
    public function hasSelectionGroup(string $hash): bool;
    public function addSelectionGroup(string $hash, array $ids): void;
    public function removeSelectionGroup(int $id): void;
}