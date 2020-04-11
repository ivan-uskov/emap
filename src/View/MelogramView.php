<?php

namespace App\View;

use App\Module\MusicXML\Api\Data\ElementInterface;
use App\Module\MusicXML\Api\Data\ElementVisitorInterface;
use App\Module\MusicXML\Api\Data\Note;
use App\Module\MusicXML\Api\Data\Pause;

class MelogramView implements ElementVisitorInterface
{
    private array $data = [];

    /**
     * @param ElementInterface[] $elements
     */
    public function __construct(array $elements)
    {
        foreach ($elements as $element)
        {
            $element->accept($this);
        }
    }

    public function visitNote(Note $note): void
    {
        // TODO: Implement visitNote() method.
    }

    public function visitPause(Pause $note): void
    {
        // TODO: Implement visitPause() method.
    }

    public function getData(): array
    {
        return $this->data;
    }
}