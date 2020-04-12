<?php

namespace App\Module\Emap\Domain\Model;

class HierarchyElementValidator
{
    /**
     * @param MelogramInterface $melogram
     * @throws \InvalidArgumentException
     */
    public static function validate(HierarchyElementInterface $melogram): void
    {
        if ($melogram->getItem() <= 0)
        {
            throw new \InvalidArgumentException('invalid item value');
        }
        if ($melogram->getFamily() <= 0)
        {
            throw new \InvalidArgumentException('invalid family value');
        }
        if ($melogram->getColony() <= 0)
        {
            throw new \InvalidArgumentException('invalid colony value');
        }
        if ($melogram->getPopulation() <= 0)
        {
            throw new \InvalidArgumentException('invalid population value');
        }
        if ($melogram->getSpecie() <= 0)
        {
            throw new \InvalidArgumentException('invalid specie value');
        }
    }
}