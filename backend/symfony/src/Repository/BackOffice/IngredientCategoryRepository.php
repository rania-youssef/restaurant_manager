<?php

namespace App\Repository\BackOffice;

use App\Entity\IngredientCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<IngredientCategory>
 */
class IngredientCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IngredientCategory::class);
    }

    /**
     * Summary of save
     * @param IngredientCategory $ingredientCategory
     * @return IngredientCategory
     */
    public function save(IngredientCategory $ingredientCategory): IngredientCategory
    {
        $em = $this->getEntityManager();
        $em->persist($ingredientCategory);
        $em->flush();
        return $ingredientCategory;
    }
}
