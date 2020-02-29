<?php

namespace App\Repository;

use App\Entity\Melogram;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Melogram|null find($id, $lockMode = null, $lockVersion = null)
 * @method Melogram|null findOneBy(array $criteria, array $orderBy = null)
 * @method Melogram[]    findAll()
 * @method Melogram[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MelogramRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Melogram::class);
    }

    // /**
    //  * @return Melogram[] Returns an array of Melogram objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Melogram
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
