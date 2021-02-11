<?php

namespace App\Repository\DamageCase\Part\Damage;

use App\Entity\DamageCase\Part\Damage\DamageCausedBy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DamageCausedBy|null find($id, $lockMode = null, $lockVersion = null)
 * @method DamageCausedBy|null findOneBy(array $criteria, array $orderBy = null)
 * @method DamageCausedBy[]    findAll()
 * @method DamageCausedBy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DamageCausedByRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DamageCausedBy::class);
    }

    // /**
    //  * @return DamageCausedBy[] Returns an array of DamageCausedBy objects
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
    public function findOneBySomeField($value): ?DamageCausedBy
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
