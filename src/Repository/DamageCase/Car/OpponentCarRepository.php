<?php

namespace App\Repository\DamageCase\Car;

use App\Entity\DamageCase\Car\OpponentCar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OpponentCar|null find($id, $lockMode = null, $lockVersion = null)
 * @method OpponentCar|null findOneBy(array $criteria, array $orderBy = null)
 * @method OpponentCar[]    findAll()
 * @method OpponentCar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OpponentCarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OpponentCar::class);
    }

    // /**
    //  * @return OpponentCar[] Returns an array of OpponentCar objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OpponentCar
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
