<?php

namespace App\Repository\DamageCase\Part;

use App\Entity\DamageCase\Part\WhoIsWarnedWithCharge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WhoIsWarnedWithCharge|null find($id, $lockMode = null, $lockVersion = null)
 * @method WhoIsWarnedWithCharge|null findOneBy(array $criteria, array $orderBy = null)
 * @method WhoIsWarnedWithCharge[]    findAll()
 * @method WhoIsWarnedWithCharge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WhoIsWarnedWithChargeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WhoIsWarnedWithCharge::class);
    }

    // /**
    //  * @return WhoIsWarnedWithCharge[] Returns an array of WhoIsWarnedWithCharge objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WhoIsWarnedWithCharge
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
