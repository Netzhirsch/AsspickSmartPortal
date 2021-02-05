<?php

namespace App\Repository\DamageCase\Part;

use App\Entity\DamageCase\Part\CriminalProceedingsAgainstTyp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CriminalProceedingsAgainstTyp|null find($id, $lockMode = null, $lockVersion = null)
 * @method CriminalProceedingsAgainstTyp|null findOneBy(array $criteria, array $orderBy = null)
 * @method CriminalProceedingsAgainstTyp[]    findAll()
 * @method CriminalProceedingsAgainstTyp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CriminalProceedingsAgainstTypRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CriminalProceedingsAgainstTyp::class);
    }

    // /**
    //  * @return CriminalProceedingsAgainstTyp[] Returns an array of CriminalProceedingsAgainstTyp objects
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
    public function findOneBySomeField($value): ?CriminalProceedingsAgainstTyp
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
