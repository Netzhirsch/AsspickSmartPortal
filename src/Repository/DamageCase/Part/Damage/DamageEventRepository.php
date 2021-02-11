<?php

namespace App\Repository\DamageCase\Part\Damage;

use App\Entity\DamageCase\Part\Damage\DamageEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DamageEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method DamageEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method DamageEvent[]    findAll()
 * @method DamageEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DamageEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DamageEvent::class);
    }

    // /**
    //  * @return DamageEvent[] Returns an array of DamageEvent objects
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
    public function findOneBySomeField($value): ?DamageEvent
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
