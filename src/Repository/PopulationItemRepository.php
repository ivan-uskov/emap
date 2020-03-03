<?php

namespace App\Repository;

use App\Entity\PopulationItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PopulationItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method PopulationItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method PopulationItem[]    findAll()
 * @method PopulationItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PopulationItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PopulationItem::class);
    }

    // /**
    //  * @return PopulationItem[] Returns an array of PopulationItem objects
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
    public function findOneBySomeField($value): ?PopulationItem
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
