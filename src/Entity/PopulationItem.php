<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

use App\Entity\Melogram;
use App\Entity\Population;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PopulationItemRepository")
 */
class PopulationItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Population")
     * @JoinColumn(name="population_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $populationId;

    /**
     * @OneToOne(targetEntity="Melogram")
     * @JoinColumn(name="item_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $itemId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPopulationId(): ?int
    {
        return $this->populationId;
    }

    public function setPopulationId(int $populationId): self
    {
        $this->populationId = $populationId;

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
