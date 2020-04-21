<?php

namespace App\Repository;

use App\Entity\SelectionGroupItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SelectionGroupItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method SelectionGroupItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method SelectionGroupItem[]    findAll()
 * @method SelectionGroupItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SelectionGroupItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SelectionGroupItem::class);
    }

    // /**
    //  * @return SelectionGroupItem[] Returns an array of SelectionGroupItem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SelectionGroupItem
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
