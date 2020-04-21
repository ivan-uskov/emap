<?php

namespace App\View;

class MelogramViewUtils
{
    public const PAUSE = 'Pause';
    private const OCTAVES = [1, 2, 3, 4, 5, 6, 7];
    private const NOTES = ['C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#', 'A', 'A#', 'B'];

    private static ?self $instance = null;

    private array $noteVariants;
    private array $noteVariantsIndexes;

    public function getVariants(): array
    {
        return $this->noteVariants;
    }

    public function getVariantsIndexes(): array
    {
        return $this->noteVariantsIndexes;
    }

    public function buildYAxis(array $rawValues): array
    {
        return array_merge(array_reverse($rawValues), [self::PAUSE]);
    }

    public function expandYAxis(array $one, array $another): array
    {
        if (empty($one))
        {
            return $another;
        }
        if (empty($another))
        {
            return $one;
        }

        $indexes = $this->getVariantsIndexes();
        $oldMin = $indexes[$one[0]];
        $oldMax = $indexes[array_reverse($one)[0]];
        $newMin = $indexes[$another[0]];
        $newMax = $indexes[array_reverse($another)[0]];

        return $this->getRawYAxis(min($oldMin, $newMin), max($oldMax, $newMax));
    }

    public function getRawYAxis(int $min, int $max): array
    {
        return array_slice($this->noteVariants, $min, $max - $min + 1);
    }

    public function buildCode(int $octave, string $note): string
    {
        $spaces = '   ';

        if (strlen($note) === 2) {
            $spaces = '  ';
        }

        return $octave . $spaces . $note;
    }

    public static function get(): self
    {
        if (self::$instance === null)
        {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        $this->noteVariants = [];
        foreach (self::OCTAVES as $octave) {
            foreach (self::NOTES as $note) {
                $this->noteVariants[] = $this->buildCode($octave, $note);
            }
        }

        $this->noteVariantsIndexes = array_flip($this->noteVariants);
    }
}