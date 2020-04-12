<?php

namespace App\Module\Emap\Api\Output;

use App\Module\Emap\App\Service\Data\SelectionData;

class SelectionsListOutput
{
    /** @var SelectionData[] */
    private array $selections;

    /**
     * @param SelectionData[] $selections
     */
    public function __construct(array $selections)
    {
        $this->selections = $selections;
    }

    public function asArray(): array
    {
        return array_map(fn(SelectionData $data) => ['id' => $data->getId(), 'uids' => $data->getUids()], $this->selections);
    }
}