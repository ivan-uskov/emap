<?php

namespace App\Module\MusicXML\Api;

interface ApiInterface
{
    public function parse(string $xml): array;
}