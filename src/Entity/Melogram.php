<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MelogramRepository")
 */
class Melogram
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $uid;

    /**
     * @ORM\Column(type="integer")
     */
    private $item;

    /**
     * @ORM\Column(type="integer")
     */
    private $family;

    /**
     * @ORM\Column(type="integer")
     */
    private $colony;

    /**
     * @ORM\Column(type="integer")
     */
    private $population;

    /**
     * @ORM\Column(type="integer")
     */
    private $specie;

    /**
     * @ORM\Column(type="blob")
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fileName;

    public function getId(): ?int
    {
        return $this->id;
    }
}
