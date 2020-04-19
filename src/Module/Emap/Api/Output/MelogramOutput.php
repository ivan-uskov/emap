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

    public function getFile(): string
    {
        return $this->data->getFile();
    }

    public function getUid(): string
    {
        return $this->data->getUid();
    }

    public function getFileName() :string
    {
        return $this->data->getFileName();
    }
}