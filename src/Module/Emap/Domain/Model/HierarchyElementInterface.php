<?php

namespace App\Module\Emap\Domain\Model;

interface HierarchyElementInterface
{
    public function getItem(): int;
    public function getFamily(): int;
    public function getColony(): int;
    public function getPopulation(): int;
    public function getSpecie(): int;
}