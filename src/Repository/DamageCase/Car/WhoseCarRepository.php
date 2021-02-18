<?php

namespace App\Repository\DamageCase\Car;

use App\Entity\DamageCase\Car\WhoseCar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WhoseCar|null find($id, $lockMode = null, $lockVersion = null)
 * @method WhoseCar|null findOneBy(array $criteria, array $orderBy = null)
 * @method WhoseCar[]    findAll()
 * @method WhoseCar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WhoseCarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WhoseCar::class);
    }

    // /**
    //  * @return WhoseCar[] Returns an array of WhoseCar objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WhoseCar
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
