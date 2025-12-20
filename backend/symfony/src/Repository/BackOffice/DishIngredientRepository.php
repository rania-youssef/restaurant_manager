<?php

namespace App\Repository\BackOffice;

use App\Entity\DishIngredient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DishIngredient>
 */
class DishIngredientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DishIngredient::class);
    }

    /**
     * Summary of save
     * @param DishIngredient $dishIngredient
     * @return DishIngredient
     */
    public function save(DishIngredient $dishIngredient): DishIngredient
    {
        $em = $this->getEntityManager();
        $em->persist($dishIngredient);
        $em->flush();
        return $dishIngredient;
    }

}
