<?php

namespace App\Repository\DamageCase\GeneralDamage\BuildingDamage;

use App\Entity\DamageCase\GeneralDamage\BuildingDamage\BuildingDamage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BuildingDamage|null find($id, $lockMode = null, $lockVersion = null)
 * @method BuildingDamage|null findOneBy(array $criteria, array $orderBy = null)
 * @method BuildingDamage[]    findAll()
 * @method BuildingDamage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuildingDamageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BuildingDamage::class);
    }

    // /**
    //  * @return BuildingDamage[] Returns an array of BuildingDamage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BuildingDamage
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
