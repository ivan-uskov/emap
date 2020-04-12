<?php

namespace App\Module\Emap\Infrastructure\Persistence\Doctrine;

use App\Module\Emap\Domain\Model\Melogram;
use App\Module\Emap\Domain\Model\MelogramRepositoryInterface;

use App\Module\Emap\Domain\Model\MelogramSpecification;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Driver\Statement;
use Doctrine\ORM\EntityManagerInterface;

class MelogramRepository implements MelogramRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->em = $manager;
    }

    public function removeMelogram(int $id): void
    {
        $this->query('DELETE FROM melogram WHERE id = :id', ['id' => $id]);
    }

    public function addMelogram(MelogramSpecification $m): void
    {
        $sql = "
            INSERT INTO
              melogram
            SET
              uid = :uid,
              file = :file,
              item = {$m->getItem()},
              family = {$m->getFamily()},
              colony = {$m->getColony()},
              population = {$m->getPopulation()},
              specie = {$m->getSpecie()}
        ";

        $this->query($sql, ['uid' => $m->getUid(), 'file' => $m->getFile()]);
    }

    public function updateMelogram(Melogram $m): void
    {
        $sql = "
            UPDATE
              melogram
            SET
              uid = :uid,
              file = :file,
              item = {$m->getItem()},
              family = {$m->getFamily()},
              colony = {$m->getColony()},
              population = {$m->getPopulation()},
              specie = {$m->getSpecie()}
            WHERE
              id = :id
        ";

        $this->query($sql, ['uid' => $m->getUid(), 'file' => $m->getFile(), 'id' => $m->getId()]);
    }

    public function hasMelogram(string $uid): bool
    {
        $stmt = $this->query('SELECT id FROM melogram WHERE melogram.uid = :uid LIMIT 1', ['uid' => $uid]);
        return !empty($stmt->fetchAll(FetchMode::ASSOCIATIVE));
    }

    public function getMelogram(int $id): Melogram
    {
        $stmt = $this->query('SELECT * FROM melogram WHERE id = :id LIMIT 1', ['id' => $id]);
        $res = $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        if (empty($res))
        {
            return null;
        }

        return new Melogram(
            $id,
            $res[0]['uid'],
            $res[0]['item'],
            $res[0]['family'],
            $res[0]['colony'],
            $res[0]['population'],
            $res[0]['specie'],
            $res[0]['file']
        );
    }

    private function query(string $sql, array $params = []): Statement
    {
        $stmt = $this->em->getConnection()->prepare($sql);
        foreach ($params as $key => $val)
        {
            $stmt->bindValue($key, $val);
        }
        $stmt->execute();
        return $stmt;
    }
}