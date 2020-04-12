<?php

namespace App\View;

use App\Module\MusicXML\Api\Data\ElementInterface;
use App\Module\MusicXML\Api\Data\ElementVisitorInterface;
use App\Module\MusicXML\Api\Data\Note;
use App\Module\MusicXML\Api\Data\Pause;

class MelogramView implements ElementVisitorInterface
{
    private array $notes = [];

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
            $this->notes[] = MelogramViewUtils::PAUSE;
        }
    }

    public function getData(): array
    {
        return [
            'notes' => $this->notes,
            'yAxis' => MelogramViewUtils::get()->buildYAxis($this->getRawYAxis()),
        ];
    }

    public function getNotes(): array
    {
        return $this->notes;
    }

    public function getRawYAxis(): array
    {
        $min = null;
        $max = null;
        $indexes = MelogramViewUtils::get()->getVariantsIndexes();
        foreach ($this->notes as $note)
        {
            if ($note === MelogramViewUtils::PAUSE)
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
        ++$max;

        return MelogramViewUtils::get()->getRawYAxis($min, $max);
    }

    private function getNoteCode(Note $note): string
    {
        $utils = MelogramViewUtils::get();
        $code = $utils->buildCode($note->getOctave(), $note->getStep());
        if ($note->getAlter() === null)
        {
            return $code;
        }

        // calculate note code wuth dièse and bemolle
        $noteIndex = $utils->getVariantsIndexes()[$code];
        return $utils->getVariants()[$noteIndex + $note->getAlter()];
    }
}