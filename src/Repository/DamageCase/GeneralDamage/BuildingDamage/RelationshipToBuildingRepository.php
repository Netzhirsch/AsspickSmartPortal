<?php

namespace App\Repository\DamageCase\GeneralDamage\BuildingDamage;

use App\Entity\DamageCase\GeneralDamage\BuildingDamage\RelationshipToBuilding;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RelationshipToBuilding|null find($id, $lockMode = null, $lockVersion = null)
 * @method RelationshipToBuilding|null findOneBy(array $criteria, array $orderBy = null)
 * @method RelationshipToBuilding[]    findAll()
 * @method RelationshipToBuilding[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RelationshipToBuildingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RelationshipToBuilding::class);
    }

    // /**
    //  * @return RelationshipToBuilding[] Returns an array of RelationshipToBuilding objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RelationshipToBuilding
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
