<?php

namespace App\Module\MusicXML\Infrastructure;

use App\Module\MusicXML\Api\Data\ElementInterface;
use App\Module\MusicXML\Api\Data\Note;
use App\Module\MusicXML\Api\Data\Pause;

class MusicXmlParser
{
    /**
     * @param string $xml
     * @return ElementInterface[]
     */
    public static function parse(string $xml): array
    {
        $notes = self::parseXml($xml);

        $result = [];
        foreach ($notes['part']['measure'] as $measure)
        {
            foreach ($measure['note'] as $note)
            {
                $result[] = self::parseNote($note);
            }
        }

        return $result;
    }

    private static function parseNote(array $note): ElementInterface
    {
        if (array_key_exists('rest', $note))
        {
            return new Pause($note['duration']);
        }

        return new Note(
            (string) $note['pitch']['step'],
            (int) $note['pitch']['octave'],
            array_key_exists('alter', $note['pitch']) ? (int) $note['pitch']['alter'] : null,
            (int) $note['duration'],
            (string) $note['type'],
            (string) $note['stem']
        );
    }

    private static function parseXml(string $xml): array
    {
        $xmlJson = json_encode((array)simplexml_load_string($xml), JSON_THROW_ON_ERROR, 512);
        return json_decode($xmlJson, true, 512, JSON_THROW_ON_ERROR);
    }
}