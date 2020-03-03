<?php

namespace App\Repository;

use App\Entity\Colony;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Colony|null find($id, $lockMode = null, $lockVersion = null)
 * @method Colony|null findOneBy(array $criteria, array $orderBy = null)
 * @method Colony[]    findAll()
 * @method Colony[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ColonyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Colony::class);
    }

    // /**
    //  * @return Colony[] Returns an array of Colony objects
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
    public function findOneBySomeField($value): ?Colony
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
