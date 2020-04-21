<?php

namespace App\Module\Emap\Infrastructure\Persistence\Doctrine;

use App\Module\Emap\Domain\Model\SelectionGroupRepositoryInterface;
use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManagerInterface;

class SelectionGroupRepository implements SelectionGroupRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->em = $manager;
    }

    public function filterIds(array $ids): array
    {
        [$keysStr, $params] = $this->prepareIdsPlaceholders($ids);
        $stmt = $this->query("
            SELECT
                id
            FROM
                selection
            WHERE
                id IN ({$keysStr})
        ", $params);

        $res = $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        return array_map(fn($item) => $item['id'], $res);
    }

    public function hasSelectionGroup(string $hash): bool
    {
        $stmt = $this->query('SELECT * FROM selection_group WHERE hash = :hash', ['hash' => $hash]);
        return !empty($stmt->fetchAll());
    }

    public function addSelectionGroup(string $hash, array $ids): void
    {
        $this->query('INSERT INTO selection_group SET hash = :hash, date = NOW()', ['hash' => $hash]);

        [$keysStr, $params] = $this->prepareIdsPlaceholders($ids);
        $this->query("
            INSERT INTO
                selection_group_item
                (selection_group_id, selection_id)
            SELECT
                sg.id, s.id
            FROM
                selection s
                INNER JOIN selection_group sg ON (sg.hash = :hash)
            WHERE
                s.id IN ({$keysStr})
        ", array_merge($params, ['hash' => $hash]));
    }

    public function removeSelectionGroup(int $id): void
    {
        $this->query("DELETE FROM selection_group WHERE id = {$id}");
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


    private function prepareIdsPlaceholders(array $ids): array
    {
        $keys = [];
        $params = [];
        foreach ($ids as $i => $iValue)
        {
            $key = 'param' . $i;
            $params[$key] = $iValue;
            $keys[] = ':' . $key;
        }

        return [implode(', ', $keys), $params];
    }
}