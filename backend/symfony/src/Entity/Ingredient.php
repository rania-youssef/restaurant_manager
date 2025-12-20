<?php

namespace App\Entity;

use App\Repository\BackOffice\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $label = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $quantityValue = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $unit = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $validity = null;

    #[ORM\ManyToOne(inversedBy: 'ingredients')]
    private ?IngredientCategory $category= null;

    /**
     * @var Collection<int, DishIngredient>
     */
    #[ORM\OneToMany(targetEntity: DishIngredient::class, mappedBy: 'ingredient')]
    private Collection $dishIngredients;

    public function __construct()
    {
        $this->dishIngredients = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getQuantityValue(): ?string
    {
        return $this->quantityValue;
    }

    public function setQuantityValue(?string $quantityValue): static
    {
        $this->quantityValue = $quantityValue;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(?string $unit): static
    {
        $this->unit = $unit;

        return $this;
    }

    public function getValidity(): ?string
    {
        return $this->validity;
    }

    public function setValidity(?string $validity): static
    {
        $this->validity = $validity;

        return $this;
    }

    public function getCategory(): ?IngredientCategory
    {
        return $this->category;
    }

    public function setCategory(?IngredientCategory $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, DishIngredient>
     */
    public function getDishIngredients(): Collection
    {
        return $this->dishIngredients;
    }

    public function addDishIngredient(DishIngredient $dishIngredient): static
    {
        if (!$this->dishIngredients->contains($dishIngredient)) {
            $this->dishIngredients->add($dishIngredient);
            $dishIngredient->setIngredient($this);
        }

        return $this;
    }

    public function removeDishIngredient(DishIngredient $dishIngredient): static
    {
        if ($this->dishIngredients->removeElement($dishIngredient)) {
            // set the owning side to null (unless already changed)
            if ($dishIngredient->getIngredient() === $this) {
                $dishIngredient->setIngredient(null);
            }
        }

        return $this;
    }

    /**
     * 
     * @return array
     */
    public function jsonSerialize()  {
        $category = [];
        if ($this->getCategory()) {
            $category['id'] = $this->getCategory()->getId();
            $category['label'] = $this->getCategory()->getLabel();
        }
        return [
            'id' => $this->getId(),
            'label' => $this->getLabel(),
            'quantityValue' => $this->getQuantityValue(),
            'unit' => $this->getUnit(),
            'category' => $category
        ];
    }
}
