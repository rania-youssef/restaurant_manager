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
     * @var Collection<int, Dishe>
     */
    #[ORM\ManyToMany(targetEntity: Dishe::class, mappedBy: 'ingredients')]
    private Collection $dishe;

    public function __construct()
    {
        $this->dishe = new ArrayCollection();
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
     * @return Collection<int, Dishe>
     */
    public function getDishe(): Collection
    {
        return $this->dishe;
    }

    public function addDish(Dishe $dish): static
    {
        if (!$this->dishe->contains($dish)) {
            $this->dishe->add($dish);
            $dish->addIngredient($this);
        }

        return $this;
    }

    public function removeDish(Dishe $dish): static
    {
        if ($this->dishe->removeElement($dish)) {
            $dish->removeIngredient($this);
        }

        return $this;
    }

    /**
     * 
     * @return array
     */
    public function jsonSerialize()  {
        $dishes = [];
        foreach ($this->getDishe() as $dishe) {
            $dishes[] = $dishe->jsonSerialize();
        }
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
            'category' => $category,
            'dishes' => $dishes
        ];
    }
}
