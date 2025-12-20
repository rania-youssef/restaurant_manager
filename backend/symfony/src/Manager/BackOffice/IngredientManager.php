<?php

namespace App\Manager\BackOffice;


use App\Entity\Ingredient;
use App\Repository\BackOffice\IngredientRepository;
use App\Repository\BackOffice\IngredientCategoryRepository;

class IngredientManager
{
    /**
     * @var IngredientRepository $ingredientRepository
     */
    private IngredientRepository $ingredientRepository;

    /**
     * @var IngredientCategoryRepository $ingredientCategoryRepository
     */
    private IngredientCategoryRepository $ingredientCategoryRepository;

    /**
     * @param IngredientRepository $ingredientRepository
     * @param IngredientCategoryRepository $ingredientCategoryRepository
     */

    public function __construct(
        IngredientRepository $ingredientRepository,
        IngredientCategoryRepository $ingredientCategoryRepository
    ) {
        $this->ingredientRepository = $ingredientRepository;
        $this->ingredientCategoryRepository = $ingredientCategoryRepository;
    }

    /**
     * Summary of list
     * @return Ingredient[]
     */
    public function list(array $data): array {
        if (empty($data) === true) {
            return $this->ingredientRepository->findAll();
        } if (isset($data['id']) === true) {
            $ingredient = $this->ingredientRepository->find((int) $data['id']);
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
            if (isset($data['quantityValue']) === true) {
                $ingredient->setQuantityValue($data['quantityValue']);
            }
            if (isset($data['unit']) === true) {
                $ingredient->setUnit($data['unit']);
            }
            if (isset($data['ingredientCategory']) === true && $data['ingredientCategory'] > 0) {
                $ingredient->setCategory($this->ingredientCategoryRepository->find((int) $data['ingredientCategory']));
            }
            return $this->ingredientRepository->save($ingredient);
        } catch(\Exception $e) {
            return null;
        }
    }
 
}