<?php

namespace App\Module\Emap\Infrastructure\Persistence\Doctrine;

use App\Module\Emap\Domain\Model\SelectionRepositoryInterface;
use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManagerInterface;

class SelectionRepository implements SelectionRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->em = $manager;
    }

    public function filterUids(array $uids): array
    {
        [$keysStr, $params] = $this->prepareUidsPlaceholders($uids);
        $stmt = $this->query("
            SELECT
                uid
            FRO
                melogram
            WHERE
                uid IN ({$keysStr})
        ", $params);

        $res = $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        return array_map(fn($item) => $item['uid'], $res);
    }

    public function hasSelection(string $hash): bool
    {
        $stmt = $this->query('SELECT * FROM selection WHERE hash = :hash', ['hash' => $hash]);
        return !empty($stmt->fetchAll());
    }

    public function addSelection(string $hash, array $uids): void
    {
        $this->query('INSERT INTO selection SET hash = :hash, date = NOW()', ['hash' => $hash]);

        [$keysStr, $params] = $this->prepareUidsPlaceholders($uids);
        $this->query("
            INSERT INTO
                selection_item
                (selection_id, melogram_id)
            SELECT
                s.id, m.id
            FROM
                melogram m
                INNER JOIN selection s ON (s.hash = :hash)
            WHERE
                m.uid IN ({$keysStr})
        ", array_merge($params, ['hash' => $hash]));
    }

    public function removeSelection(int $id): void
    {
        $this->query("DELETE FROM selection WHERE id = {$id}");
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

    private function prepareUidsPlaceholders(array $uids): array
    {
        $keys = [];
        $params = [];
        foreach ($uids as $i => $iValue)
        {
            $key = 'param' . $i;
            $params[$key] = $iValue;
            $keys[] = ':' . $key;
        }

        return [implode(', ', $keys), $params];
    }
}