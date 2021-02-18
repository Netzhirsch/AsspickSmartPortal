<?php

namespace App\Repository\DamageCase\Car;

use App\Entity\DamageCase\Car\TypOfTrip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypOfTrip|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypOfTrip|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypOfTrip[]    findAll()
 * @method TypOfTrip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypOfTripRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypOfTrip::class);
    }

    // /**
    //  * @return TypeOfTrip[] Returns an array of TypeOfTrip objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeOfTrip
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
