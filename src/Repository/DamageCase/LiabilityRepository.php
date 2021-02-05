<?php

namespace App\Repository\DamageCase;

use App\Entity\DamageCase\Liability;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Liability|null find($id, $lockMode = null, $lockVersion = null)
 * @method Liability|null findOneBy(array $criteria, array $orderBy = null)
 * @method Liability[]    findAll()
 * @method Liability[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LiabilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Liability::class);
    }

    // /**
    //  * @return Liability[] Returns an array of Liability objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Liability
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
