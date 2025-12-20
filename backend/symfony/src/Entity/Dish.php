<?php

namespace App\Entity;

use App\Repository\BackOffice\DishRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DishRepository::class)]
class Dish
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $label = null;

    /**
     * @var Collection<int, DishIngredient>
     */
    #[ORM\OneToMany(targetEntity: DishIngredient::class, mappedBy: 'dish')]
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
            $dishIngredient->setDish($this);
        }

        return $this;
    }

    public function removeDishIngredient(DishIngredient $dishIngredient): static
    {
        if ($this->dishIngredients->removeElement($dishIngredient)) {
            // set the owning side to null (unless already changed)
            if ($dishIngredient->getDish() === $this) {
                $dishIngredient->setDish(null);
            }
        }

        return $this;
    }

    /**
     * 
     * @return array
     */
    public function jsonSerialize()  {
        return [
            'id' => $this->getId(),
            'label' => $this->getLabel()
        ];
    }
}
