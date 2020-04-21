<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SelectionGroupItemRepository")
 */
class SelectionGroupItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="SelectionGroup")
     * @JoinColumn(name="selection_group_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $selectionGroupId;

    /**
     * @ManyToOne(targetEntity="Selection")
     * @JoinColumn(name="selection_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $selectionId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSelectionGroupId(): ?int
    {
        return $this->selectionGroupId;
    }

    public function setSelectionGroupId(int $selectionGroupId): self
    {
        $this->selectionGroupId = $selectionGroupId;

        return $this;
    }

    public function getSelectionId(): ?int
    {
        return $this->selectionId;
    }

    public function setSelectionId(int $selectionId): self
    {
        $this->selectionId = $selectionId;

        return $this;
    }
}
