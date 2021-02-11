<?php

namespace App\Repository\DamageCase\GeneralDamage;

use App\Entity\DamageCase\GeneralDamage\GeneralDamage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GeneralDamage|null find($id, $lockMode = null, $lockVersion = null)
 * @method GeneralDamage|null findOneBy(array $criteria, array $orderBy = null)
 * @method GeneralDamage[]    findAll()
 * @method GeneralDamage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GeneralDamageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GeneralDamage::class);
    }

    // /**
    //  * @return GeneralDamage[] Returns an array of GeneralDamage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GeneralDamage
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
