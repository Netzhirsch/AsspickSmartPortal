<?php

namespace App\Repository\DamageCase\Part;

use App\Entity\DamageCase\Part\PoliceRecording;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PoliceRecording|null find($id, $lockMode = null, $lockVersion = null)
 * @method PoliceRecording|null findOneBy(array $criteria, array $orderBy = null)
 * @method PoliceRecording[]    findAll()
 * @method PoliceRecording[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PoliceRecordingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PoliceRecording::class);
    }

    // /**
    //  * @return PoliceRecording[] Returns an array of PoliceRecording objects
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
    public function findOneBySomeField($value): ?PoliceRecording
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
