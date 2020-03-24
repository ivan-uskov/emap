<?php


namespace App\Module\Emap\Domain\Service;

use \Tmont\Midi\Parsing\FileParser;
use \Tmont\Midi\Event as Event;
use \Tmont\Midi\Util\Note;

class MelogramParser
{
    public function __construct() {}

    //public function getMelogramArray(id): array
    public function getMelogramArray(): array
    {
        //$fileName = $this->getMidiFileByMelogramId();
        $fileName = '\emap1\melogramExample\melo1.mid';
        $melogramArray = $this->getParsedMidiFile($fileName);
        $dataPoints = $this->convertMelogramArray($melogramArray);
        return $dataPoints;
    }

    //public function getMelogramArray(список id): array
    public function getMelogramArrayList(): array {
        $this->getMelogramArray();
        return array();
    }

    private function getMidiFileByMelogramId(): string {
        return "";
    }

    private function getParsedMidiFile(string $fileName): array {
        $parser = new FileParser();
        $parser->load($fileName);
        $noteArray = array();

        $currentTrackName = null;
        while ($chunk = $parser->parse()) {
            if ($chunk instanceof Event\TrackNameEvent) {
                $currentTrackName = $chunk->getParamDescription();
            } else if ($chunk instanceof Event\NoteOnEvent) {
                list($channel, $noteNumber, $velocity) = $chunk->getData();
                if ($velocity) {
                    $noteName = Note::getNoteName($noteNumber);
                    array_push($noteArray, $noteName);
                    //echo $currentTrackName . ': [' . $channel . '] ' . $noteName .
                    //   ' (velocity=' . $velocity . ')' . PHP_EOL;
                }
            }
        }

        return $noteArray;
    }

    private function convertMelogramArray(array $melogramArray): array {
        $dataPoints = array();
        $time = 10;

        foreach ($melogramArray as &$value) {
            $digitNote = $this->convetNoteToDigit($value);
            array_push($dataPoints,  array("y"=> $digitNote, "label"=> "".$time));
            $time += 10;
        }

        return $dataPoints;
    }

    private function convetNoteToDigit(string $noteName): int{
        switch ($noteName[0]) {
            case "C":
                return 1;
            case "D":
                return 2;
            case "E":
                return 3;
            case "F":
                return 4;
            case "G":
                return 5;
            case "A":
                return 6;
            case "B":
                return 7;
        }

        return 0;
    }
}