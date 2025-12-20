<?php

namespace App\Manager\BackOffice;

use App\Entity\DishIngredient;
use App\Repository\BackOffice\DishIngredientRepository;
use App\Repository\BackOffice\IngredientRepository;
use App\Repository\BackOffice\DishRepository;

class DishIngredientManager
{
    /**
     * @var DishIngredientRepository $dishIngredientRepository
     */
    private DishIngredientRepository $dishIngredientRepository;


    /**
     * @var IngredientRepository $ingredientRepository
     */
    private IngredientRepository $ingredientRepository;

    /**
     * @var DishRepository $dishRepository
     */
    private DishRepository $dishRepository;

    /**
     * @param IngredientRepository $ingredientRepository
     * @param DishRepository $dishRepository
     */

    public function __construct(
        DishIngredientRepository $dishIngredientRepository,
        IngredientRepository $ingredientRepository,
        DishRepository $dishRepository
    ) {
        $this->dishIngredientRepository = $dishIngredientRepository;
        $this->ingredientRepository = $ingredientRepository;
        $this->dishRepository = $dishRepository;
    }

    /**
     * Summary of list
     * @return DishIngredient[]
     */
    public function list(array $data): array {
        if (empty($data) === true) {
            return $this->dishIngredientRepository->findAll();
        } if (isset($data['id']) === true) {
            $dishIngredient= $this->dishIngredientRepository->find((int) $data['id']);
            return $dishIngredient ? [$dishIngredient] : [];
        } else {
            return $this->dishIngredientRepository->findBy($data);
        }
    }

    /**
     * 
     * @param array $data
     * @return DishIngredient|null
     */
    public function create(array $data): mixed {
        try  {
            $dishIngredient = new DishIngredient();
            if (isset($data['quantity']) === true) {
                $dishIngredient->setQuantity($data['quantity']);
            }
            if (isset($data['unit']) === true) {
                $dishIngredient->setUnit($data['unit']);
            }
            if (isset($data['ingredientId']) === true && $data['ingredientId'] > 0) {
                $ingredient = $this->ingredientRepository->find((int) $data['ingredientId']);
                if (empty($ingredient) === false) {
                    $dishIngredient->setIngredient($ingredient);
                }
            }
            if (isset($data['dishId']) === true && $data['dishId'] > 0) {
                $dish = $this->dishRepository->find((int) $data['dishId']);
                if (empty($dish) === false) {
                    $dishIngredient->setDish($dish);
                }
            }
            return $this->dishIngredientRepository->save($dishIngredient);  
        } catch(\Exception $e) {
            return null;
        }
    }
 
}