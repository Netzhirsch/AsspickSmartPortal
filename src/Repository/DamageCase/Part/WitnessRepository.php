<?php

namespace App\Repository\DamageCase\Part;

use App\Entity\DamageCase\Part\Witness;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Witness|null find($id, $lockMode = null, $lockVersion = null)
 * @method Witness|null findOneBy(array $criteria, array $orderBy = null)
 * @method Witness[]    findAll()
 * @method Witness[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WitnessRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Witness::class);
    }

    // /**
    //  * @return Witness[] Returns an array of Witness objects
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
    public function findOneBySomeField($value): ?Witness
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
