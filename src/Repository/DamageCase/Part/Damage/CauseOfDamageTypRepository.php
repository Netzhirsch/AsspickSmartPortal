<?php

namespace App\Repository\DamageCase\Part\Damage;

use App\Entity\DamageCase\Part\Damage\CauseOfDamageTyp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CauseOfDamageTyp|null find($id, $lockMode = null, $lockVersion = null)
 * @method CauseOfDamageTyp|null findOneBy(array $criteria, array $orderBy = null)
 * @method CauseOfDamageTyp[]    findAll()
 * @method CauseOfDamageTyp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CauseOfDamageTypRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CauseOfDamageTyp::class);
    }

    // /**
    //  * @return CauseOfDamageTyp[] Returns an array of CauseOfDamageTyp objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CauseOfDamageTyp
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
