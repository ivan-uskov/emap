<?php

namespace App\Module\Emap\Domain\Service;

use App\Module\Emap\Domain\Model\SelectionRepositoryInterface;

class SelectionService
{
    private SelectionRepositoryInterface $repository;

    public function __construct(SelectionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function add(array $uids): void
    {
        $uids = $this->repository->filterUids($uids);
        $hash = $this->getHash($uids);

        if (!$this->repository->hasSelection($hash))
        {
            $this->repository->addSelection($hash, $uids);
        }
    }

    private function getHash(array $uids): string
    {
        sort($uids);
        return md5(implode('_', $uids));
    }
}