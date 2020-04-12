<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SelectionItemRepository")
 */
class SelectionItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Selection")
     * @JoinColumn(name="selection_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $selectionId;

    /**
     * @ManyToOne(targetEntity="Melogram")
     * @JoinColumn(name="melogram_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $melogramId;

    public function getId(): ?int
    {
        return $this->id;
    }
}
