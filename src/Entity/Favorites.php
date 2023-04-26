<?php

namespace App\Entity;

use App\Repository\FavoritesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FavoritesRepository::class)
 */
class Favorites
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=Fruits::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Fruits $fruit;

    // ... other properties and methods ...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFruit(): ?Fruits
    {
        return $this->fruit;
    }

    public function setFruit(Fruits $fruit): self
    {
        $this->fruit = $fruit;

        return $this;
    }
}
