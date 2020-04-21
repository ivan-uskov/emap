<?php

namespace App\Module\Emap\Domain\Service;

use App\Module\Emap\Domain\Model\SelectionGroupRepositoryInterface;

class SelectionGroupService
{
    private SelectionGroupRepositoryInterface $repository;

    public function __construct(SelectionGroupRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function add(array $ids): void
    {
        $ids = $this->repository->filterIds($ids);
        $hash = $this->getHash($ids);

        if (!$this->repository->hasSelectionGroup($hash))
        {
            $this->repository->addSelectionGroup($hash, $ids);
        }
    }

    public function remove(int $id): void
    {
        $this->repository->removeSelectionGroup($id);
    }

    private function getHash(array $ids): string
    {
        $ids = array_unique($ids);
        sort($ids);
        return md5(implode('_', $ids));
    }
}