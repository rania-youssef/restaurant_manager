<?php

namespace App\Manager\BackOffice;

use App\Entity\Dish;
use App\Repository\BackOffice\DishRepository;
use App\Repository\BackOffice\IngredientRepository;

class DishManager
{
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
        IngredientRepository $ingredientRepository,
        DishRepository $dishRepository
    ) {
        $this->ingredientRepository = $ingredientRepository;
        $this->dishRepository = $dishRepository;
    }

    /**
     * Summary of list
     * @return Dish[]
     */
    public function list(array $data): array {
        if (empty($data) === true) {
            return $this->dishRepository->findAll();
        } if (isset($data['id']) === true) {
            $dish = $this->dishRepository->find((int) $data['id']);
            return $dish ? [$dish] : [];
        } else {
            return $this->dishRepository->findBy($data);
        }
    }

    /**
     * 
     * @param array $data
     * @return Dish|null
     */
    public function create(array $data): mixed {
        try  {
            $dish = new Dish();
            if (isset($data['label']) === true) {
                $dish->setLabel($data['label']);
            }
            return $this->dishRepository->save($dish);  
        } catch(\Exception $e) {
            return null;
        }
    }
 
}