<?php

namespace App\Repository\DamageCase\GeneralDamage;

use App\Entity\DamageCase\GeneralDamage\RepairCompany;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RepairCompany|null find($id, $lockMode = null, $lockVersion = null)
 * @method RepairCompany|null findOneBy(array $criteria, array $orderBy = null)
 * @method RepairCompany[]    findAll()
 * @method RepairCompany[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepairCompanyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RepairCompany::class);
    }

    // /**
    //  * @return RepairCompany[] Returns an array of RepairCompany objects
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
    public function findOneBySomeField($value): ?RepairCompany
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
