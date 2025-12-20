<?php

namespace App\Entity;

use App\Repository\DishIngredientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DishIngredientRepository::class)]
class DishIngredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'dishIngredients')]
    private ?Dish $dish = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $quantity = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $unit = null;

    #[ORM\ManyToOne(inversedBy: 'dishIngredients')]
    private ?Ingredient $ingredient = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDish(): ?Dish
    {
        return $this->dish;
    }

    public function setDish(?Dish $dish): static
    {
        $this->dish = $dish;

        return $this;
    }

    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    public function setQuantity(?string $quantity): static
    {
        $this->quantity = $quantity;

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

    public function getIngredient(): ?Ingredient
    {
        return $this->ingredient;
    }

    public function setIngredient(?Ingredient $ingredient): static
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    /**
     * 
     * @return array
     */
    public function jsonSerialize()  {
        $ingredientDish = [];
        if (empty($this->ingredient) === false) {
            $ingredientDish = $this->ingredient->jsonSerialize();
        }
        $dish = [];
        if (empty($this->dish) === false) {
            $dish = $this->dish->jsonSerialize();
        }
        return [
            'id' => $this->getId(),
            'quantity' => $this->getQuantity(),
            'unit' => $this->getUnit(),
            'ingredientDish' => $ingredientDish,
            'dish' => $dish
        ];
    }
}
