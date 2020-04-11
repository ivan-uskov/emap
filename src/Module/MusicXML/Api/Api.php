<?php

namespace App\Module\MusicXML\Api;

use App\Module\MusicXML\Infrastructure\MusicXmlParser;

class Api implements ApiInterface
{
    public function parse(string $xml): array
    {
        return MusicXmlParser::parse($xml);
    }
}