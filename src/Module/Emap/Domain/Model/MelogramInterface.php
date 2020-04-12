<?php

namespace App\Module\Emap\Domain\Model;

interface MelogramInterface extends HierarchyElementInterface
{
    public function getUid(): string;
    public function getFile(): string;
}