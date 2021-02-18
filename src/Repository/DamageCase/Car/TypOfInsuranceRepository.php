<?php

namespace App\Repository\DamageCase\Car;

use App\Entity\DamageCase\Car\TypOfInsurance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypOfInsurance|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypOfInsurance|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypOfInsurance[]    findAll()
 * @method TypOfInsurance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypOfInsuranceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypOfInsurance::class);
    }

    // /**
    //  * @return TypeOfInsurance[] Returns an array of TypeOfInsurance objects
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
    public function findOneBySomeField($value): ?TypeOfInsurance
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
