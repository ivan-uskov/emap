<?php

namespace App\Module\Emap\Infrastructure\Persistence\Doctrine;

use App\Module\Emap\Domain\Model\Melogram;
use App\Module\Emap\Domain\Model\MelogramRepositoryInterface;

use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManagerInterface;

class MelogramRepository implements MelogramRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->em = $manager;
    }

    public function addMelogram(Melogram $m): void
    {
        $sql = "
            INSERT INTO
              melogram
            SET
              name = :name
        ";

        $stmt = $this->em->getConnection()->prepare($sql)->setParameter(':name', $m->getName());
        $stmt->execute();
    }
}