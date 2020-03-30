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

    private string $insertSpecieQuery = 'INSERT INTO specie SET name = :name';
    private string $insertPopulationQuery = 'INSERT INTO population SET name = :name, specie_id = :specieId';
    private string $insertColonyQuery = 'INSERT INTO colony SET name = :name, population_id = :populationId';
    private string $insertFamilyQuery = 'INSERT INTO family SET name = :name, colony_id = :colonyId';

    private string $getSpecieIdQuery = 'SELECT id FROM specie WHERE name = :name';
    private string $getPopulationIdQuery = 'SELECT id FROM population WHERE name = :name AND specie_id = :specieId';
    private string $getColonyIdQuery = 'SELECT id FROM colony WHERE name = :name AND population_id = :populationId';
    private string $getFamilyIdQuery = 'SELECT id FROM family WHERE name =:name AND colony_id = :colonyId';

    public function __construct(EntityManagerInterface $manager)
    {
        $this->em = $manager;
    }

    public function removeMelogram(int $id): void
    {
        $this->query('DELETE FROM melogram WHERE id = :id', ['id' => $id]);
    }

    private function getOrCreateEntityId(string $name, string $getQuery, $getQueryArguments
        , string $insertQuery, $queryArguments):int
    {
        $entityIdArray = $this->query($getQuery, $getQueryArguments)->fetch();
        if(empty($entityIdArray) || !array_key_exists('id', $entityIdArray)) {
            $this->query($insertQuery, $queryArguments);
        }
        return $this->query($getQuery, $getQueryArguments)->fetch()['id'];
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

        $this->query($sql, ['name' => $m->getItemId(), 'file' => $m->getFile()]);
        $id = $this->getLastInsertId();

        $specieId = $this->getOrCreateEntityId($m->getSpecieId()
            , $this->getSpecieIdQuery, ['name' => $m->getSpecieId()]
            , $this->insertSpecieQuery, ['name' => $m->getSpecieId()]);
        $populationId = $this->getOrCreateEntityId($m->getPopulationId()
            , $this->getPopulationIdQuery, ['name' => $m->getPopulationId(), 'specieId' => $specieId]
            , $this->insertPopulationQuery, ['name' => $m->getPopulationId(), 'specieId' => $specieId]);
        $colonyId = $this->getOrCreateEntityId($m->getColonyId()
            , $this->getColonyIdQuery, ['name'=>$m->getColonyId(), 'populationId' => $populationId]
            , $this->insertColonyQuery, ['name' => $m->getColonyId(), 'populationId' => $populationId]);
        $familyId = $this->getOrCreateEntityId($m->getFamilyId()
            , $this->getFamilyIdQuery, ['name' => $m->getFamilyId(), 'colonyId' => $colonyId]
            , $this->insertFamilyQuery, ['name' => $m->getFamilyId(), 'colonyId' => $colonyId]);

        $hierarchyIds = $this->getHierarchyIds($familyId);
        if ((int) $hierarchyIds['family_id'] > 0)
        {
            $this->query('INSERT INTO family_item SET family_id = :family_id, item_id = :item_id', ['family_id' => $familyId, 'item_id' => $id]);
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

    public function updateMelogram(Melogram $m): void
    {
        $sql = "
            UPDATE
              melogram
            SET
              name = :name,
              file = :file
            WHERE
              id = :id
        ";

        $id = $m->getId();
        $this->query($sql, ['name' => $m->getName(), 'file' => $m->getFile(), 'id' => $m->getId()]);

        $hierarchyIds = $this->getHierarchyIds($m->getFamilyId());
        if ($hierarchyIds === null)
        {
            return;
        }

        if ((int) $hierarchyIds['family_id'] > 0)
        {
            $this->query('UPDATE family_item SET family_id = :family_id WHERE item_id = :item_id', ['family_id' => $m->getFamilyId(), 'item_id' => $id]);
        }
        if ((int) $hierarchyIds['colony_id'] > 0)
        {
            $this->query('UPDATE colony_item SET colony_id = :colony_id WHERE item_id = :item_id', ['colony_id' => $hierarchyIds['colony_id'], 'item_id' => $id]);
        }
        if ((int) $hierarchyIds['population_id'] > 0)
        {
            $this->query('UPDATE population_item SET population_id = :population_id WHERE item_id = :item_id', ['population_id' => $hierarchyIds['population_id'], 'item_id' => $id]);
        }
        if ((int) $hierarchyIds['specie_id'] > 0)
        {
            $this->query('UPDATE specie_item SET specie_id = :specie_id WHERE item_id = :item_id', ['specie_id' => $hierarchyIds['specie_id'], 'item_id' => $id]);
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

    public function getMelogram(int $id): Melogram
    {
        $t = 'SELECT
              f.name AS family_id,
              c.name AS colony_id,
              p.name AS population_id,
              s.name AS specie_id
            FROM
              family f
              LEFT JOIN colony c ON (c.id = f.colony_id)
              LEFT JOIN population p ON (c.population_id = p.id)
              LEFT JOIN specie s ON (p.specie_id = s.id)
            WHERE
              f.id = :id
            LIMIT 1';

        $sql = "
            SELECT
              m.id,
              m.name,
              file,
              fi.name AS family_id
            FROM
              melogram m
              LEFT JOIN family_item fi ON (m.id = fi.item_id)
              
            WHERE
              m.id = :id
            LIMIT 1
        ";

        $stmt = $this->query($sql, ['id' => $id]);
        $res = $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        if (empty($res))
        {
            return null;
        }

        return new Melogram($id, $res[0]['name'], $res[0]['family_id'], $res[0]['file']);
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