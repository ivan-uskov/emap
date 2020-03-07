<?php

namespace App\Module\Emap\Infrastructure\Persistence\Doctrine;

use App\Module\Emap\Domain\Model\Melogram;
use App\Module\Emap\Domain\Model\MelogramRepositoryInterface;

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

    public function addMelogram(Melogram $m): void
    {
        $sql = "
            INSERT INTO
              melogram
            SET
              name = :name,
              file = :file
        ";

        $this->query($sql, ['name' => $m->getName(), 'file' => $m->getFile()]);
        $id = $this->getLastInsertId();

        $hierarchyIds = $this->getHierarchyIds($m->getFamilyId());
        if ($hierarchyIds === null)
        {
            return;
        }

        if ((int) $hierarchyIds['family_id'] > 0)
        {
            $this->query('INSERT INTO family_item SET family_id = :family_id, item_id = :item_id', ['family_id' => $m->getFamilyId(), 'item_id' => $id]);
        }
        if ((int) $hierarchyIds['colony_id'] > 0)
        {
            $this->query('INSERT INTO colony_item SET colony_id = :colony_id, item_id = :item_id', ['colony_id' => $hierarchyIds['colony_id'], 'item_id' => $id]);
        }
        if ((int) $hierarchyIds['population_id'] > 0)
        {
            $this->query('INSERT INTO population_item SET population_id = :population_id, item_id = :item_id', ['population_id' => $hierarchyIds['population_id'], 'item_id' => $id]);
        }
        if ((int) $hierarchyIds['specie_id'] > 0)
        {
            $this->query('INSERT INTO specie_item SET specie_id = :specie_id, item_id = :item_id', ['specie_id' => $hierarchyIds['specie_id'], 'item_id' => $id]);
        }
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

        $stmt = $this->query($sql, ['name' => $name]);

        return !empty($stmt->fetchAll(FetchMode::ASSOCIATIVE));
    }

    private function getHierarchyIds(int $familyId): ?array
    {
        $sql = "
            SELECT
              f.id AS family_id,
              c.id AS colony_id,
              p.id AS population_id,
              s.id AS specie_id
            FROM
              family f
              LEFT JOIN colony c ON (c.id = f.colony_id)
              LEFT JOIN population p ON (c.population_id = p.id)
              LEFT JOIN specie s ON (p.specie_id = s.id)
            WHERE
              f.id = :id
            LIMIT 1
        ";

        $stmt = $this->query($sql, ['id' => $familyId]);
        $rows = $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        return count($rows) > 0 ? $rows[0] : null;
    }

    private function getLastInsertId(): int
    {
        $stmt = $this->query("SELECT LAST_INSERT_ID() AS id");
        return (int) $stmt->fetchColumn();
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