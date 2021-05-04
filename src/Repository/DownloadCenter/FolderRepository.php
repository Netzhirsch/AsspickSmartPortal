<?php

namespace App\Repository\DownloadCenter;

use App\Entity\DownloadCenter\Folder;
use App\Filter\UserViewFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Folder|null find($id, $lockMode = null, $lockVersion = null)
 * @method Folder|null findOneBy(array $criteria, array $orderBy = null)
 * @method Folder[]    findAll()
 * @method Folder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FolderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Folder::class);
    }

    /**
     * @return Folder[]
     */
    public function findParents(): array
    {
        $qb = $this->createQueryBuilder('f');
        $this->addOrder($qb);
	    $qb->where('f.parent IS NULL');

        return $qb->getQuery()->getResult();
    }

    public function getQueryBuilder(): QueryBuilder
    {
        $qb = $this->createQueryBuilder('f');
        $this->addOrder($qb);
        return $qb;
    }

    private function addOrder(QueryBuilder $qb){
        $qb->orderBy('f.name');
    }

    /**
     * @return Folder[]
     */
    public function findParentsVisible(?UserViewFilter $filter): array
    {
        $qb = $this->createQueryBuilder('f');
        $this->addOrder($qb);
        $qb->where('f.isVisible = 1');

        if (!empty($filter)) {
            $name = $filter->getName();
            if (!empty($name)) {
                $qb
                    ->leftJoin('f.files', 'files')
                    ->andWhere('f.name LIKE :name OR files.name LIKE :name')
                    ->setParameter('name', '%'.$name.'%')
                ;
            }
        } else {
            $qb
                ->andWhere('f.parent IS NULL')
            ;
        }

        return $qb->getQuery()->getResult();
    }
}
