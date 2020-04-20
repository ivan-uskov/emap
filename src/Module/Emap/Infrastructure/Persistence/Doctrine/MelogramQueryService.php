<?php

namespace App\Module\Emap\Infrastructure\Persistence\Doctrine;

use App\Module\Emap\App\Service\Data\MelogramData;
use App\Module\Emap\App\Service\MelogramQueryServiceInterface;
use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManagerInterface;

class MelogramQueryService implements MelogramQueryServiceInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->em = $manager;
    }

    /**
     * @inheritDoc
     */
    public function getMelogram(int $id): ?MelogramData
    {
        $stmt = $this->query("SELECT * FROM melogram WHERE id = {$id} LIMIT 1");

        $data = $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        return (count($data) > 0) ? $this->melogram($data[0]) : null;
    }

    /**
     * @inheritDoc
     */
    public function getAllMelograms(): array
    {
        $stmt = $this->query('SELECT * FROM melogram ORDER BY specie, population, colony, family, item');
        $mapper = fn(array $data) => $this->melogram($data);

        return array_map($mapper, $stmt->fetchAll(FetchMode::ASSOCIATIVE));
    }

    private function melogram(array $data): MelogramData
    {
        return new MelogramData(
            $data['id'],
            $data['uid'],
            $data['item'],
            $data['family'],
            $data['colony'],
            $data['population'],
            $data['specie'],
            $data['file'],
            $data['file_name']
        );
    }

    public function getMelogramsByHierarchy(int $item, int $family, int $colony, int $population, int $specie): array
    {
        $sql = 'SELECT * FROM melogram m ';
        $whereClauses = [];
        if ($specie !== 0)
        {
            $whereClauses[] = "m.specie = {$specie}";
        }
        if ($population !== 0)
        {
            $whereClauses[] = "m.population = {$population}";
        }
        if ($colony !== 0)
        {
            $whereClauses[] = "m.colony = {$colony}";
        }
        if ($family !== 0)
        {
            $whereClauses[] = "m.family = {$family}";
        }
        if ($item !== 0)
        {
            $whereClauses[] = "m.item = {$item}";
        }

        $whereClause = empty($whereClauses) ? '' : 'WHERE ' . implode(' AND ', $whereClauses);
        $stmt = $this->query($sql . $whereClause);
        $mapper = fn(array $data) => $this->melogram($data);

        return array_map($mapper, $stmt->fetchAll(FetchMode::ASSOCIATIVE));
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