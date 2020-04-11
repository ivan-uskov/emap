<?php

namespace App\Module\MusicXML\Api\Data;

class Pause implements ElementInterface
{
    private int $duration;

    public function __construct(int $duration)
    {
        $this->duration = $duration;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function accept(ElementVisitorInterface $visitor): void
    {
        $visitor->visitPause($this);
    }
}