<?php

namespace App\Repository;

use App\Entity\Fibu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Fibu|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fibu|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fibu[]    findAll()
 * @method Fibu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FibuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fibu::class);
    }

    // /**
    //  * @return Fibo[] Returns an array of Fibo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Fibo
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
