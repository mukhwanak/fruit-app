<?php

namespace App\Entity;

use App\Repository\NutritionsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NutritionsRepository::class)]
class Nutrition
{
    #[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: 'integer')]
	private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
	#[ORM\Column(type: 'string', length: 255, nullable: true)]

    private ?string $calories = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
	private ?string $fat = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
	private ?string $sugar = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
	private ?string $carbohydrates = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
	private ?string $protein = null;

    /**
     * @ORM\OneToOne(targetEntity=Fruit::class, mappedBy="nutrition")
     * @ORM\JoinColumn(name="fruit_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private ?Fruit $fruit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCalories(): ?string
    {
        return $this->calories;
    }

    public function setCalories(?string $calories): self
    {
        $this->calories = $calories;

        return $this;
    }

    public function getFat(): ?string
    {
        return $this->fat;
    }

    public function setFat(?string $fat): self
    {
        $this->fat = $fat;

        return $this;
    }

    public function getSugar(): ?string
    {
        return $this->sugar;
    }

    public function setSugar(?string $sugar): self
    {
        $this->sugar = $sugar;

        return $this;
    }

    public function getCarbohydrates(): ?string
    {
        return $this->carbohydrates;
    }

    public function setCarbohydrates(?string $carbohydrates): self
    {
        $this->carbohydrates = $carbohydrates;

        return $this;
    }

    public function getProtein(): ?string
    {
        return $this->protein;
    }

    public function setProtein(?string $protein): self
    {
        $this->protein = $protein;

        return $this;
    }

    public function getFruit(): ?Fruit
    {
        return $this->fruit;
    }

    public function setFruit(?Fruit $fruit): self
    {
        $this->fruit = $fruit;

        // set (or unset) the owning side of the relation if necessary
        if ($fruit !== null) {
            $fruit->setNutritions($this);
        }

        return $this;
    }
}
