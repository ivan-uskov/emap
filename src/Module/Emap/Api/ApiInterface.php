<?php

namespace App\Module\Emap\Api;

use App\Module\Emap\Api\Output\MelogramsListOutput;

interface ApiInterface
{
    public function getMelogramsList(): MelogramsListOutput;
}