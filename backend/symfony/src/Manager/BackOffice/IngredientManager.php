<?php

namespace App\Manager\BackOffice;


use App\Entity\Ingredient;
use App\Repository\BackOffice\IngredientRepository;

class IngredientManager
{
    /**
     * @var IngredientRepository $ingredientRepository
     */
    private IngredientRepository $ingredientRepository;

    /**
     * @param IngredientRepository $ingredientRepository
     */

    public function __construct(IngredientRepository $ingredientRepository)
    {
        $this->ingredientRepository = $ingredientRepository;
    }

    /**
     * Summary of list
     * @return Ingredient[]
     */
    public function list(array $data): array {
        if (empty($data) === true) {
            return $this->ingredientRepository->findAll();
        } if (isset($data['id']) === true) {
            $ingredient = $this->ingredientRepository->find($data['id']);
            return $ingredient ? [$ingredient] : [];
        } else {
            return $this->ingredientRepository->findBy($data);
        }
    }

    /**
     * 
     * @param array $data
     * @return Ingredient|null
     */
    public function create(array $data): mixed {
        try  {
            $ingredient = new Ingredient();
            if (isset($data['label']) === true) {
                $ingredient->setLabel($data['label']);
            }
            if (isset($data['quantity']) === true) {
                $ingredient->setQuantityValue($data['quantity']);
            }
            if (isset($data['unit']) === true) {
                $ingredient->setUnit($data['unit']);
            }
            return $this->ingredientRepository->save($ingredient);
        } catch(\Exception $e) {
            return null;
        }
    }
 
}