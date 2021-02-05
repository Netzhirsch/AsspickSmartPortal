<?php

namespace App\Repository\DamageCase\Part;

use App\Entity\DamageCase\Part\Policyholder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Policyholder|null find($id, $lockMode = null, $lockVersion = null)
 * @method Policyholder|null findOneBy(array $criteria, array $orderBy = null)
 * @method Policyholder[]    findAll()
 * @method Policyholder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PolicyholderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Policyholder::class);
    }

    // /**
    //  * @return Policyholder[] Returns an array of Policyholder objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Policyholder
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
