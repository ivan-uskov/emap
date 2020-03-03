<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

use App\Entity\Melogram;
use App\Entity\Specie;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SpecieItemRepository")
 */
class SpecieItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Specie")
     * @JoinColumn(name="specie_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $specieId;

    /**
     * @OneToOne(targetEntity="Melogram")
     * @JoinColumn(name="item_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $itemId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSpecieId(): ?int
    {
        return $this->specieId;
    }

    public function setSpecieId(int $specieId): self
    {
        $this->specieId = $specieId;

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
