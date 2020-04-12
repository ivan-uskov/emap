<?php

namespace App\View;

use App\Module\MusicXML\Api\Data\ElementInterface;
use App\Module\MusicXML\Api\Data\ElementVisitorInterface;
use App\Module\MusicXML\Api\Data\Note;
use App\Module\MusicXML\Api\Data\Pause;

class MelogramView implements ElementVisitorInterface
{
    private const PAUSE = 'Pause';
    private const OCTAVES = [1, 2, 3, 4, 5, 6, 7];
    private const NOTES = ['C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#', 'A', 'A#', 'B'];

    private array $notesVariants = [];
    private array $notes = [];

    /**
     * @param ElementInterface[] $elements
     */
    public function __construct(array $elements)
    {
        $this->initNoteVariants();

        foreach ($elements as $element)
        {
            $element->accept($this);
        }
    }

    public function visitNote(Note $note): void
    {
        $duration = $note->getDuration();
        while ($duration-- > 0)
        {
            $this->notes[] = $this->getNoteCode($note);
        }
    }

    public function visitPause(Pause $note): void
    {
        $duration = $note->getDuration();
        while ($duration-- > 0)
        {
            $this->notes[] = self::PAUSE;
        }
    }

    public function getData(): array
    {
        return [
            'notes' => $this->notes,
            'yAxis' => $this->getYAxis(),
        ];
    }

    private function getYAxis(): array
    {
        $min = null;
        $max = null;
        $indexes = array_flip($this->notesVariants);
        foreach ($this->notes as $note)
        {
            if ($note === self::PAUSE)
            {
                continue;
            }
            if ($min === null || ($indexes[$note] < $min))
            {
                $min = $indexes[$note];
            }
            if ($max === null || ($indexes[$note] > $max))
            {
                $max = $indexes[$note];
            }
        }

        return array_merge(array_reverse(array_slice($this->notesVariants, $min, $max - $min + 1)), [self::PAUSE]);
    }

    private function getNoteCode(Note $note): string
    {
        $code = $this->buildCode($note->getOctave(), $note->getStep());
        if ($note->getAlter() === null)
        {
            return $code;
        }

        // calculate note code wuth dièse and bemolle
        $noteIndex = array_flip($this->notesVariants)[$code];
        return $this->notesVariants[$noteIndex + $note->getAlter()];
    }

    private function initNoteVariants(): void
    {
        foreach (self::OCTAVES as $octave)
        {
            foreach (self::NOTES as $note)
            {
                $this->notesVariants[] = $this->buildCode($octave, $note);
            }
        }
    }

    private function buildCode(int $octave, string $note): string
    {
        $spaces = '   ';

        if (strlen($note) === 2)
        {
            $spaces = '  ';
        }

        return $octave . $spaces . $note;
    }
}