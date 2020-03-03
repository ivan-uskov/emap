<?php

namespace App\Repository;

use App\Entity\FamilyItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FamilyItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method FamilyItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method FamilyItem[]    findAll()
 * @method FamilyItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FamilyItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FamilyItem::class);
    }

    // /**
    //  * @return FamilyItem[] Returns an array of FamilyItem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FamilyItem
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
