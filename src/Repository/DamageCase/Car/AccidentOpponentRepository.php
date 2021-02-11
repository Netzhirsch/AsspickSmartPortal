<?php

namespace App\Repository\DamageCase\Car;

use App\Entity\DamageCase\Car\AccidentOpponent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AccidentOpponent|null find($id, $lockMode = null, $lockVersion = null)
 * @method AccidentOpponent|null findOneBy(array $criteria, array $orderBy = null)
 * @method AccidentOpponent[]    findAll()
 * @method AccidentOpponent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccidentOpponentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccidentOpponent::class);
    }

    // /**
    //  * @return AccidentOpponent[] Returns an array of AccidentOpponent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AccidentOpponent
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
