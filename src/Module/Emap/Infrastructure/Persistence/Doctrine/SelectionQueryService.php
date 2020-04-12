<?php

namespace App\Module\Emap\Infrastructure\Persistence\Doctrine;

use App\Module\Emap\App\Service\Data\SelectionData;
use App\Module\Emap\App\Service\SelectionQueryServiceInterface;
use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManagerInterface;

class SelectionQueryService implements SelectionQueryServiceInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->em = $manager;
    }

    public function getSelections(): array
    {
        $stmt = $this->query("
            SELECT
                s.id,
                s.hash,
                s.date,
                GROUP_CONCAT(m.uid SEPARATOR ',') AS uids
            FROM
                selection s
                INNER JOIN selection_item si on s.id = si.selection_id
                INNER JOIN melogram m on si.melogram_id = m.id
            GROUP BY
                s.id
        ");
        $mapper = fn(array $data) => new SelectionData(
            $data['id'],
            $data['date'],
            array_flip(explode(',', $data['uids'])),
        );

        return array_map($mapper, $stmt->fetchAll(FetchMode::ASSOCIATIVE));
    }

    public function getSelection(int $id): ?SelectionData
    {
        $stmt = $this->query("
            SELECT
                s.id,
                s.date,
                m.uid,
                m.file
            FROM
                selection s
                INNER JOIN selection_item si on s.id = si.selection_id
                INNER JOIN melogram m on si.melogram_id = m.id
            WHERE
                s.id = {$id}
        ");

        $res = $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        if (empty($res))
        {
            return null;
        }

        $uidsWithFiles = [];
        foreach ($res as $row)
        {
            $uidsWithFiles[$row['uid']] = $row['file'];
        }

        return new SelectionData($id, $res[0]['date'], $uidsWithFiles);
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