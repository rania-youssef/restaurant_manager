<?php

namespace App\Repository\BackOffice;

use App\Entity\Ingredient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ingredient>
 */
class IngredientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ingredient::class);
    }

    /**
     * Summary of save
     * @param Ingredient $ingredient
     * @return Ingredient
     */
    public function save(Ingredient $ingredient): Ingredient
    {
        $em = $this->getEntityManager();
        $em->persist($ingredient);
        $em->flush();
        return $ingredient;
    }

}
