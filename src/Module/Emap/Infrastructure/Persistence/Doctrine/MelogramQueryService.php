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
    public function getAllMelograms(): array
    {
        $sql = "
            SELECT
              m.id,
              m.name,
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

        $mapper = function (array $data): MelogramData {
            return new MelogramData(
                $data['id'],
                $data['name'],
                $data['family_name'],
                $data['colony_name'],
                $data['population_name'],
                $data['specie_name'],
                []
            );
        };

        return array_map($mapper, $stmt->fetchAll(FetchMode::ASSOCIATIVE));
    }
}