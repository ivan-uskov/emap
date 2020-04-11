<?php

namespace App\Module\MusicXML\Api\Data;

interface ElementInterface
{
    public function accept(ElementVisitorInterface $visitor): void;
}