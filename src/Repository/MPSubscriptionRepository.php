<?php

namespace App\Repository;

use App\Entity\MPSubscription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MPSubscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method MPSubscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method MPSubscription[]    findAll()
 * @method MPSubscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MPSubscriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MPSubscription::class);
    }

    // /**
    //  * @return MPSubscription[] Returns an array of MPSubscription objects
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
    public function findOneBySomeField($value): ?MPSubscription
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
