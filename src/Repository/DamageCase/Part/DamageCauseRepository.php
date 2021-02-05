<?php

namespace App\Repository\DamageCase\Part;

use App\Entity\DamageCase\Part\DamageCause;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DamageCause|null find($id, $lockMode = null, $lockVersion = null)
 * @method DamageCause|null findOneBy(array $criteria, array $orderBy = null)
 * @method DamageCause[]    findAll()
 * @method DamageCause[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DamageCauseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DamageCause::class);
    }

    // /**
    //  * @return DamageCause[] Returns an array of DamageCause objects
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
    public function findOneBySomeField($value): ?DamageCause
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
