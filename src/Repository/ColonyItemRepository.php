<?php

namespace App\Repository;

use App\Entity\ColonyItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ColonyItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method ColonyItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method ColonyItem[]    findAll()
 * @method ColonyItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ColonyItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ColonyItem::class);
    }

    // /**
    //  * @return ColonyItem[] Returns an array of ColonyItem objects
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
    public function findOneBySomeField($value): ?ColonyItem
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
