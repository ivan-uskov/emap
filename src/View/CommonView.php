<?php

namespace App\View;

class CommonView
{
    private int $maxLength = 0;
    private array $yAxis = [];
    private array $notes = [];

    public function __construct(array $melograms)
    {
        foreach ($melograms as $uid => $melogram)
        {
            /** @var MelogramView $view */
            $view = $melogram['view'];
            $this->expandYAxis($view->getRawYAxis());
            $this->expandMaxLength($view->getNotes());
            $this->notes[] = ['uid' => $uid, 'notes' => $view->getNotes()];
        }
    }

    public function getData(): array
    {
        return [
            'length' => $this->maxLength,
            'values' => $this->notes,
            'yAxis' => MelogramViewUtils::get()->buildYAxis($this->yAxis),
        ];
    }

    private function expandMaxLength(array $notes): void
    {
        $new = count($notes);
        if ($new > $this->maxLength)
        {
            $this->maxLength = $new;
        }
    }

    private function expandYAxis(array $yAxis): void
    {
        if (empty($this->yAxis))
        {
            $this->yAxis = $yAxis;
            return;
        }

        $indexes = MelogramViewUtils::get()->getVariantsIndexes();
        $oldMin = $indexes[$this->yAxis[0]];
        $oldMax = $indexes[array_reverse($this->yAxis)[0]];
        $newMin = $indexes[$this->yAxis[0]];
        $newMax = $indexes[array_reverse($this->yAxis)[0]];

        $this->yAxis = MelogramViewUtils::get()->getRawYAxis(min($oldMin, $newMin), max($oldMax, $newMax));
    }
}