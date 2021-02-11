<?php

namespace App\Repository\DamageCase\GeneralDamage;

use App\Entity\DamageCase\GeneralDamage\TraceOfBreakIn;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TraceOfBreakIn|null find($id, $lockMode = null, $lockVersion = null)
 * @method TraceOfBreakIn|null findOneBy(array $criteria, array $orderBy = null)
 * @method TraceOfBreakIn[]    findAll()
 * @method TraceOfBreakIn[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TraceOfBreakInRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TraceOfBreakIn::class);
    }

    // /**
    //  * @return TraceOfBreakIn[] Returns an array of TraceOfBreakIn objects
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
    public function findOneBySomeField($value): ?TraceOfBreakIn
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
