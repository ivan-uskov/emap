<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

use App\Entity\Family;
use App\Entity\Melogram;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FamilyItemRepository")
 */
class FamilyItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Family")
     * @JoinColumn(name="family_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $familyId;

    /**
     * @OneToOne(targetEntity="Melogram")
     * @JoinColumn(name="item_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $itemId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFamilyId(): ?int
    {
        return $this->familyId;
    }

    public function setFamilyId(int $familyId): self
    {
        $this->familyId = $familyId;

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
