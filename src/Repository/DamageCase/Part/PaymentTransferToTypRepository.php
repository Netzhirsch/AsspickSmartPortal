<?php

namespace App\Repository\DamageCase\Part;

use App\Entity\DamageCase\Part\PaymentTransferToTyp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PaymentTransferToTyp|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaymentTransferToTyp|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaymentTransferToTyp[]    findAll()
 * @method PaymentTransferToTyp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentTransferToTypRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaymentTransferToTyp::class);
    }

    // /**
    //  * @return PaymentTransferToTyp[] Returns an array of PaymentTransferToTyp objects
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
    public function findOneBySomeField($value): ?PaymentTransferToTyp
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
