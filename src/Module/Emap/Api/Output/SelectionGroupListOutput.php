<?php

namespace App\Module\Emap\Api\Output;

use App\Module\Emap\App\Service\Data\SelectionGroupData;

class SelectionGroupListOutput
{
    /** @var SelectionGroupData[] */
    private array $items;

    public function __construct(array $selectionGroups)
    {
        $this->items = $selectionGroups;
    }

    public function asArray(): array
    {
        return array_map(fn(SelectionGroupData $data) => [
            'id' => $data->getId(),
            'date' => $data->getDate(),
            'uids' => $data->getIds(),
        ], $this->items);
    }
}