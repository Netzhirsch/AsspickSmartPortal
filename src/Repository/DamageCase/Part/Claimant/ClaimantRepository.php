<?php

namespace App\Repository\DamageCase\Part\Claimant;

use App\Entity\DamageCase\Part\Claimant\Claimant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Claimant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Claimant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Claimant[]    findAll()
 * @method Claimant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClaimantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Claimant::class);
    }

    // /**
    //  * @return Claimant[] Returns an array of Claimant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Claimant
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
