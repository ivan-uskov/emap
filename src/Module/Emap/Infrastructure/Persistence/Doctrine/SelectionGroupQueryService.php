<?php

namespace App\Module\Emap\Infrastructure\Persistence\Doctrine;

use App\Module\Emap\App\Service\Data\SelectionGroupData;
use App\Module\Emap\App\Service\SelectionGroupQueryServiceInterface;
use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManagerInterface;

class SelectionGroupQueryService implements SelectionGroupQueryServiceInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->em = $manager;
    }

    public function getSelectionGroups(): array
    {
        $stmt = $this->query("
            SELECT
                sg.id,
                sg.date,
                GROUP_CONCAT(s.id SEPARATOR ',') AS ids
            FROM
                selection_group sg
                INNER JOIN selection_group_item sgi ON sg.id = sgi.selection_group_id
                INNER JOIN selection s ON s.id = sgi.selection_id
            GROUP BY
                sg.id
        ");
        $mapper = fn(array $data) => new SelectionGroupData(
            $data['id'],
            $data['date'],
            explode(',', $data['ids']),
        );

        return array_map($mapper, $stmt->fetchAll(FetchMode::ASSOCIATIVE));
    }

    public function getSelectionGroup(int $id): ?SelectionGroupData
    {
        $stmt = $this->query("
            SELECT
                sg.id,
                sg.date,
                GROUP_CONCAT(s.id SEPARATOR ',') AS ids
            FROM
                selection_group sg
                INNER JOIN selection_group_item sgi ON sg.id = sgi.selection_group_id
                INNER JOIN selection s ON s.id = sgi.selection_id
            WHERE
                sg.id = {$id}
            GROUP BY
                sg.id
            LIMIT 1
        ");

        $res = $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        if (empty($res))
        {
            return null;
        }

        return new SelectionGroupData($res[0]['id'], $res[0]['date'], explode(',', $res[0]['ids']));
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