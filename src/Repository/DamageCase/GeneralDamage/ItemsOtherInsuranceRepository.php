<?php

namespace App\Repository\DamageCase\GeneralDamage;

use App\Entity\DamageCase\GeneralDamage\ItemsOtherInsurance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ItemsOtherInsurance|null find($id, $lockMode = null, $lockVersion = null)
 * @method ItemsOtherInsurance|null findOneBy(array $criteria, array $orderBy = null)
 * @method ItemsOtherInsurance[]    findAll()
 * @method ItemsOtherInsurance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemsOtherInsuranceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItemsOtherInsurance::class);
    }

    // /**
    //  * @return ItemsOtherInsurance[] Returns an array of ItemsOtherInsurance objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ItemsOtherInsurance
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
