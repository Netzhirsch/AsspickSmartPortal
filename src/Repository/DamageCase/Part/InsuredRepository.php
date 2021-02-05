<?php

namespace App\Repository\DamageCase\Part;

use App\Entity\DamageCase\Part\Insured;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Insured|null find($id, $lockMode = null, $lockVersion = null)
 * @method Insured|null findOneBy(array $criteria, array $orderBy = null)
 * @method Insured[]    findAll()
 * @method Insured[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InsuredRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Insured::class);
    }

    // /**
    //  * @return Insured[] Returns an array of Insured objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Insured
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
