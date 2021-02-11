<?php

namespace App\Repository\DamageCase\Part\Damage;

use App\Entity\DamageCase\Part\Damage\DamageTyp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DamageTyp|null find($id, $lockMode = null, $lockVersion = null)
 * @method DamageTyp|null findOneBy(array $criteria, array $orderBy = null)
 * @method DamageTyp[]    findAll()
 * @method DamageTyp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DamageTypRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DamageTyp::class);
    }

    // /**
    //  * @return DamageTyp[] Returns an array of DamageTyp objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DamageTyp
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
