<?php

namespace App\Module\Emap\Domain\Model;

class UidBuilder
{
    public static function build(HierarchyElementInterface $element): string
    {
        return implode('.', [$element->getSpecie(), $element->getPopulation(), $element->getColony(), $element->getFamily(), $element->getItem()]);
    }
}