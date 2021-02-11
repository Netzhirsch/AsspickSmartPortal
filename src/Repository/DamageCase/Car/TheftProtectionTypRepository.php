<?php

namespace App\Repository\DamageCase\Car;

use App\Entity\DamageCase\Car\TheftProtectionTyp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TheftProtectionTyp|null find($id, $lockMode = null, $lockVersion = null)
 * @method TheftProtectionTyp|null findOneBy(array $criteria, array $orderBy = null)
 * @method TheftProtectionTyp[]    findAll()
 * @method TheftProtectionTyp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TheftProtectionTypRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TheftProtectionTyp::class);
    }

    // /**
    //  * @return TheftProtectionTyp[] Returns an array of TheftProtectionTyp objects
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
    public function findOneBySomeField($value): ?TheftProtectionTyp
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
