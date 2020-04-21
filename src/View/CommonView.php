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
            $this->yAxis = MelogramViewUtils::get()->expandYAxis($this->yAxis, $view->getRawYAxis());
            $this->expandMaxLength($view->getNotes());
            $this->notes[] = ['uid' => $uid, 'notes' => $view->getNotes()];
        }
    }

    public function getRawYAxis(): array
    {
        return $this->yAxis;
    }

    public function getMaxLength(): int
    {
        return $this->maxLength;
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
}