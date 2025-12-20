<?php

namespace App\Manager\BackOffice;

use App\Entity\IngredientCategory;
use App\Repository\BackOffice\IngredientCategoryRepository;

class IngredientCategoryManager
{
    /**
     * @var IngredientCategoryRepository $ingredientCategoryRepository
     */
    private IngredientCategoryRepository $ingredientCategoryRepository;

    /**
     * @param IngredientCategoryRepository $ingredientCategoryRepository
     */

    public function __construct(IngredientCategoryRepository $ingredientCategoryRepository)
    {
        $this->ingredientCategoryRepository = $ingredientCategoryRepository;
    }
 
    /**
     * 
     * @param array $data
     * @return IngredientCategory|null
     */
    public function create(array $data): mixed {
        try  {
            $ingredientCategory = new IngredientCategory();
            if (isset($data['label']) === true) {
                $ingredientCategory->setLabel($data['label']);
            }
            return $this->ingredientCategoryRepository->save($ingredientCategory);
        } catch(\Exception $e) {
            return null;
        }
    }

    /**
     * Summary of list
     * @return IngredientCategory[]
     */
    public function list(array $data): array {
        if (empty($data) === true) {
            return $this->ingredientCategoryRepository->findAll();
        } if (isset($data['id']) === true) {
            $ingredientCategory = $this->ingredientCategoryRepository->find($data['id']);
            return $ingredientCategory ? [$ingredientCategory] : [];
        } else {
            return $this->ingredientCategoryRepository->findBy($data);
        }
    }
}