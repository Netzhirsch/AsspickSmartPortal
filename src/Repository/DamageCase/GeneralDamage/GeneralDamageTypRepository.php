<?php

namespace App\Repository\DamageCase\GeneralDamage;

use App\Entity\DamageCase\GeneralDamage\GeneralDamageTyp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GeneralDamageTyp|null find($id, $lockMode = null, $lockVersion = null)
 * @method GeneralDamageTyp|null findOneBy(array $criteria, array $orderBy = null)
 * @method GeneralDamageTyp[]    findAll()
 * @method GeneralDamageTyp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GeneralDamageTypRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GeneralDamageTyp::class);
    }

    // /**
    //  * @return GeneralDamageTyp[] Returns an array of GeneralDamageTyp objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GeneralDamageTyp
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
