<?php

namespace App\Repository\DamageCase\Part\Claimant;

use App\Entity\DamageCase\Part\Claimant\ClaimantTyp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClaimantTyp|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClaimantTyp|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClaimantTyp[]    findAll()
 * @method ClaimantTyp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClaimantTypRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClaimantTyp::class);
    }

    // /**
    //  * @return ClaimantTyp[] Returns an array of ClaimantTyp objects
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
    public function findOneBySomeField($value): ?ClaimantTyp
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
