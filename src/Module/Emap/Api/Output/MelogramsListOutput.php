<?php

namespace App\Module\Emap\Api\Output;

use App\Module\Emap\App\Service\Data\MelogramData;

class MelogramsListOutput
{
    private array $datas;

    /**
     * @param MelogramData[] $datas
     */
    public function __construct(array $datas)
    {
        $this->datas = $datas;
    }

    /**
     * @return array[]
     */
    public function getAsArray(): array
    {
        return array_map(fn(MelogramData $d) => $d->asArray(), $this->datas);
    }
}