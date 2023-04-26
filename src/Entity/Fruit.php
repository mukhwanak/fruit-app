<?php
namespace App\Entity;

use App\Repository\FruitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

//#[ORM\Entity(repositoryClass: FruitRepository::class)]

class Fruit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $family = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $order = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $genus = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Nutrition", mappedBy="fruit", cascade={"persist", "remove"})
     */
    private $nutritions;

    public function __construct()
    {
        $this->nutritions = new ArrayCollection();
    }

    // Getters and Setters for each property

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFamily(): ?string
    {
        return $this->family;
    }

    public function setFamily(?string $family): self
    {
        $this->family = $family;

        return $this;
    }

    public function getOrder(): ?string
    {
        return $this->order;
    }

    public function setOrder(?string $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function getGenus(): ?string
    {
        return $this->genus;
    }

    public function setGenus(?string $genus): self
    {
        $this->genus = $genus;

        return $this;
    }

    /**
     * @return Collection|Nutrition[]
     */
    public function getNutritions(): Collection
    {
        return $this->nutritions;
    }

    public function addNutrition(Nutrition $nutrition): self
    {
        if (!$this->nutritions->contains($nutrition)) {
            $this->nutritions[] = $nutrition;
            $nutrition->setFruit($this);
        }

        return $this;
    }

    public function removeNutrition(Nutrition $nutrition): self
    {
        if ($this->nutritions->contains($nutrition)) {
            $this->nutritions->removeElement($nutrition);
            // set the owning side to null (unless already changed)
            if ($nutrition->getFruit() === $this) {
                $nutrition->setFruit(null);
            }
        }

        return $this;
    }

    public function setNutritions(Collection $nutritions): self
    {
        $this->nutritions = $nutritions;

        return $this;
    }
}
