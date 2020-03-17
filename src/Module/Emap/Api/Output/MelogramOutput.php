<?php

namespace App\Module\Emap\Api\Output;

use App\Module\Emap\App\Service\Data\MelogramData;

class MelogramOutput
{
    private MelogramData $data;

    public function __construct(MelogramData $data)
    {
        $this->data = $data;
    }

    public function asArray(): array
    {
        return $this->data->asArray();
    }
}