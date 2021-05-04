<?php

namespace App\Repository\DownloadCenter;

use App\Entity\DownloadCenter\File;
use App\Filter\UserViewFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method File|null find($id, $lockMode = null, $lockVersion = null)
 * @method File|null findOneBy(array $criteria, array $orderBy = null)
 * @method File[]    findAll()
 * @method File[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, File::class);
    }

    /**
     * @return File[]
     */
    public function findNew(?UserViewFilter $filter): array
    {
        $qb = $this->createQueryBuilder('f');
        if (!empty($filter)) {
            $name = $filter->getName();
            if (!empty($name)) {
                $qb
                    ->andWhere('f.name LIKE :name')
                    ->setParameter('name', '%'.$name.'%')
                ;
            }
        }
        return $qb
            ->orderBy('f.updatedAt', 'DESC')
            ->addOrderBy('f.name', 'ASC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
        ;
    }
}
