<?php

namespace App\Repository;

use App\Entity\ActivationCode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ActivationCode|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActivationCode|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActivationCode[]    findAll()
 * @method ActivationCode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivationCodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActivationCode::class);
    }

    // /**
    //  * @return Fibo[] Returns an array of Fibo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Fibo
    {
        return $this->createQueryBuilder('a')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
