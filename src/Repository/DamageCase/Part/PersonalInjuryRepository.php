<?php

namespace App\Repository\DamageCase\Part;

use App\Entity\DamageCase\Part\PersonalInjury;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PersonalInjury|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonalInjury|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonalInjury[]    findAll()
 * @method PersonalInjury[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonalInjuryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonalInjury::class);
    }

    // /**
    //  * @return PersonalInjury[] Returns an array of PersonalInjury objects
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
    public function findOneBySomeField($value): ?PersonalInjury
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
