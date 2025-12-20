<?php

namespace App\Repository\BackOffice;

use App\Entity\Dish;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Dish>
 */
class DishRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dish::class);
    }

     /**
     * Summary of save
     * @param Dish $dish
     * @return Dish
     */
    public function save(Dish $dish): Dish
    {
        $em = $this->getEntityManager();
        $em->persist($dish);
        $em->flush();
        return $dish;
    }
}
