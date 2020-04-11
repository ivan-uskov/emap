<?php

namespace App\Module\MusicXML\Api\Data;

interface ElementVisitorInterface
{
    public function visitNote(Note $note): void;
    public function visitPause(Pause $note): void;
}