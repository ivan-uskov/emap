<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

use App\Entity\Melogram;
use App\Entity\Colony;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ColonyItemRepository")
 */
class ColonyItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Colony")
     * @JoinColumn(name="colony_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $colonyId;

    /**
     * @OneToOne(targetEntity="Melogram")
     * @JoinColumn(name="item_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $itemId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColonyId(): ?int
    {
        return $this->colonyId;
    }

    public function setColonyId(int $colonyId): self
    {
        $this->colonyId = $colonyId;

        return $this;
    }

    public function getItemId(): ?int
    {
        return $this->itemId;
    }

    public function setItemId(int $itemId): self
    {
        $this->itemId = $itemId;

        return $this;
    }
}
