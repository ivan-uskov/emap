<?php

namespace App\Module\Emap\Infrastructure\Persistence\Doctrine;

use App\Module\Emap\App\Service\Data\HierarchyVariantData;
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
              name = :name,
              file = :file
        ";

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->bindValue('name', $m->getName());
        $stmt->bindValue('file', $m->getFile());
        $stmt->execute();

        //TODO: encode file content
        //TODO: insert hierarchy rows
    }

    public function hasFamily(int $familyId): bool
    {
        $sql = "
            SELECT
              f.id
            FROM
              family f
            WHERE
              id = :id;
        ";

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->bindValue('id', $familyId);
        $stmt->execute();

        return !empty($stmt->fetchAll(FetchMode::ASSOCIATIVE));
    }

    public function hasMelogram(string $name): bool
    {
        $sql = "
            SELECT
              id
            FROM
              melogram
            WHERE
              `name` = :name;
        ";

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->bindValue('name', $name);
        $stmt->execute();

        return !empty($stmt->fetchAll(FetchMode::ASSOCIATIVE));
    }
}