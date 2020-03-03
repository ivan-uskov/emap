<?php

namespace App\Repository;

use App\Entity\MelogramAttribute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MelogramAttribute|null find($id, $lockMode = null, $lockVersion = null)
 * @method MelogramAttribute|null findOneBy(array $criteria, array $orderBy = null)
 * @method MelogramAttribute[]    findAll()
 * @method MelogramAttribute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MelogramAttributeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MelogramAttribute::class);
    }

    // /**
    //  * @return MelogramAttribute[] Returns an array of MelogramAttribute objects
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
    public function findOneBySomeField($value): ?MelogramAttribute
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
