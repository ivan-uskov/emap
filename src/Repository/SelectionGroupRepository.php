<?php

namespace App\Repository;

use App\Entity\SelectionGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SelectionGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method SelectionGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method SelectionGroup[]    findAll()
 * @method SelectionGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SelectionGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SelectionGroup::class);
    }

    // /**
    //  * @return SelectionGroup[] Returns an array of SelectionGroup objects
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
    public function findOneBySomeField($value): ?SelectionGroup
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
