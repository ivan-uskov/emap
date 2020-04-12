<?php

namespace App\Module\MusicXML\Api\Data;

class Note implements ElementInterface
{
    private string $step;
    private int $octave;
    private ?int $alter;
    private int $duration;
    private string $type;
    private string $stem;

    public function __construct(
        string $step,
        int $octave,
        ?int $alter,
        int $duration,
        string $type,
        string $stem
    ) {
        $this->step = $step;
        $this->octave = $octave;
        $this->alter = $alter;
        $this->duration = $duration;
        $this->type = $type;
        $this->stem = $stem;
    }

    public function getStep(): string
    {
        return $this->step;
    }

    public function getOctave(): int
    {
        return $this->octave;
    }

    public function getAlter(): ?int
    {
        return $this->alter;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getStem(): string
    {
        return $this->stem;
    }

    public function accept(ElementVisitorInterface $visitor): void
    {
        $visitor->visitNote($this);
    }
}