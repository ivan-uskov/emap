<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

use App\Entity\Melogram;
use App\Entity\Attribute;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MelogramAttributeRepository")
 */
class MelogramAttribute
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @OneToOne(targetEntity="Melogram")
     * @JoinColumn(name="melogram_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $melogramId;

    /**
     * @ManyToOne(targetEntity="Attribute")
     * @JoinColumn(name="attribute_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $attributeId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMelogramId(): ?int
    {
        return $this->melogramId;
    }

    public function setMelogramId(int $melogramId): self
    {
        $this->melogramId = $melogramId;

        return $this;
    }

    public function getAttributeId(): ?int
    {
        return $this->attributeId;
    }

    public function setAttributeId(int $attributeId): self
    {
        $this->attributeId = $attributeId;

        return $this;
    }
}
