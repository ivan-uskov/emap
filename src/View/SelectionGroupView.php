<?php

namespace App\View;

use App\Module\Emap\Api\Output\SelectionOutput;
use App\Module\MusicXML\Api\Api as MusicXMLApi;

class SelectionGroupView
{
    /** @var SelectionOutput[] */
    private array $selections;

    private array $yAxis = [];
    private int $length = 0;

    public function __construct(array $selections)
    {
        $this->selections = $selections;
    }

    public function asArray(): array
    {
        $items = [];
        foreach ($this->selections as $selection)
        {
            $selectionItems = [];
            foreach ($selection->getUidsWithFiles() as $uid => $file)
            {
                $selectionItems[$uid] = ['view' => new MelogramView((new MusicXMLApi())->parse($file))];
            }
            $view = new CommonView($selectionItems);

            $this->yAxis = MelogramViewUtils::get()->expandYAxis($this->yAxis, $view->getRawYAxis());
            $this->length = max($this->length, $view->getMaxLength());
            $items[] = ($view)->getData();
        }

        return [
            'items' => array_map(fn(SelectionOutput $s) => $s->getId(), $this->selections),
            'common_result' => json_encode([
                'items' => $items,
                'yAxis' => MelogramViewUtils::get()->buildYAxis($this->yAxis),
                'length' => $this->length,
            ], JSON_THROW_ON_ERROR, 512),
            'already_saved' => false
        ];
    }
}