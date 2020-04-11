<?php

namespace App\Module\Emap\Infrastructure\Persistence\Doctrine;

use App\Module\Emap\App\Service\Data\HierarchyVariantData;
use App\Module\Emap\App\Service\Data\MelogramData;
use App\Module\Emap\App\Service\MelogramQueryServiceInterface;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManagerInterface;

class MelogramQueryService implements MelogramQueryServiceInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->em = $manager;
    }

    public function getHierarchyVariants(): array
    {
        $sql = "
            SELECT
              f.id,
              f.name AS family_name,
              c.name AS colony_name,
              p.name AS population_name,
              s.name AS specie_name
            FROM
              family f
              LEFT JOIN colony c ON (c.id = f.colony_id)
              LEFT JOIN population p ON (c.population_id = p.id)
              LEFT JOIN specie s ON (p.specie_id = s.id)
        ";

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();

        $mapper = function (array $data): HierarchyVariantData {
            return new HierarchyVariantData(
                $data['id'],
                $data['family_name'],
                $data['colony_name'],
                $data['population_name'],
                $data['specie_name']
            );
        };

        return array_map($mapper, $stmt->fetchAll(FetchMode::ASSOCIATIVE));
    }

    /**
     * @inheritDoc
     */
    public function getMelogram(int $id): ?MelogramData
    {
        $sql = "
            SELECT
              m.id,
              m.name,
              m.file,
              f.id AS family_id,
              f.name AS family_name,
              c.name AS colony_name,
              p.name AS population_name,
              s.name AS specie_name
            FROM
              melogram m
              LEFT JOIN family_item fi ON (m.id = fi.item_id)
              LEFT JOIN family f ON (fi.family_id = f.id)
              LEFT JOIN colony_item ci ON (m.id = ci.item_id)
              LEFT JOIN colony c ON (c.id = ci.colony_id)
              LEFT JOIN population_item pi ON (m.id = pi.item_id)
              LEFT JOIN population p ON (pi.population_id = p.id)
              LEFT JOIN specie_item si ON (m.id = si.item_id)
              LEFT JOIN specie s ON (si.specie_id = s.id)
            WHERE
              m.id = {$id}
            LIMIT 1;
        ";

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();

        $data = $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        return (count($data) > 0) ? $this->melogram($data[0]) : null;
    }

    /**
     * @inheritDoc
     */
    public function getAllMelograms(): array
    {
        $sql = "
            SELECT
              m.id,
              m.name,
              m.file,
              f.id AS family_id,
              f.name AS family_name,
              c.name AS colony_name,
              p.name AS population_name,
              s.name AS specie_name
            FROM
              melogram m
              LEFT JOIN family_item fi ON (m.id = fi.item_id)
              LEFT JOIN family f ON (fi.family_id = f.id)
              LEFT JOIN colony_item ci ON (m.id = ci.item_id)
              LEFT JOIN colony c ON (c.id = ci.colony_id)
              LEFT JOIN population_item pi ON (m.id = pi.item_id)
              LEFT JOIN population p ON (pi.population_id = p.id)
              LEFT JOIN specie_item si ON (m.id = si.item_id)
              LEFT JOIN specie s ON (si.specie_id = s.id)
        ";

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();

        $mapper = fn(array $data) => $this->melogram($data);

        return array_map($mapper, $stmt->fetchAll(FetchMode::ASSOCIATIVE));
    }

    private function melogram(array $data): MelogramData
    {
        return new MelogramData(
            $data['id'],
            $data['name'],
            $data['file'],
            $data['family_id'],
            $data['family_name'],
            $data['colony_name'],
            $data['population_name'],
            $data['specie_name'],
            []
        );
    }

    public function getMelogramsByHierarchy(int $itemId, int $familyId, int $colonyId, int $populationId, int $specieId): array
    {
        $sql = '
            SELECT
              DISTINCT m.id,
              m.name,
              m.file,
              f.id AS family_id,
              f.name AS family_name,
              c.name AS colony_name,
              p.name AS population_name,
              s.name AS specie_name
            FROM
              melogram m
              LEFT JOIN family_item fi ON (m.id = fi.item_id)
              LEFT JOIN family f ON (fi.family_id = f.id)
              LEFT JOIN colony_item ci ON (m.id = ci.item_id)
              LEFT JOIN colony c ON (c.id = ci.colony_id)
              LEFT JOIN population_item pi ON (m.id = pi.item_id)
              LEFT JOIN population p ON (pi.population_id = p.id)
              LEFT JOIN specie_item si ON (m.id = si.item_id)
              LEFT JOIN specie s ON (si.specie_id = s.id)            
        ';
        $whereClauses = [];
        if ($specieId !== 0)
        {
            $whereClauses[] = "s.name = {$specieId}";
        }
        if ($populationId !== 0)
        {
            $whereClauses[] = "p.name = {$populationId}";
        }
        if ($colonyId !== 0)
        {
            $whereClauses[] = "c.name = {$colonyId}";
        }
        if ($familyId !== 0)
        {
            $whereClauses[] = "f.name = {$familyId}";
        }
        if ($itemId !== 0)
        {
            $whereClauses[] = "m.name = {$itemId}";
        }

        $whereClause = empty($whereClauses) ? '' : 'WHERE ' . implode(' AND ', $whereClauses);
        $stmt = $this->em->getConnection()->prepare($sql . $whereClause);
        $stmt->execute();

        $mapper = fn(array $data) => $this->melogram($data);

        return array_map($mapper, $stmt->fetchAll(FetchMode::ASSOCIATIVE));
    }
}