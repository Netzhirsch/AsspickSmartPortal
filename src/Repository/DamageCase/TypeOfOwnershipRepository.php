<?php

namespace App\Repository\DamageCase;

use App\Entity\DamageCase\TypeOfOwnership;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeOfOwnership|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeOfOwnership|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeOfOwnership[]    findAll()
 * @method TypeOfOwnership[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeOfOwnershipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeOfOwnership::class);
    }

    // /**
    //  * @return TypeOfOwnership[] Returns an array of TypeOfOwnership objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeOfOwnership
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
