<?php

namespace App\Repository;

use App\Entity\MProcessus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MProcessus|null find($id, $lockMode = null, $lockVersion = null)
 * @method MProcessus|null findOneBy(array $criteria, array $orderBy = null)
 * @method MProcessus[]    findAll()
 * @method MProcessus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MProcessusRepository extends ServiceEntityRepository
{
    const ALIAS='mp';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MProcessus::class);
    }


    public function findAllForAdmin()
    {
        return $this->createQueryBuilder(self::ALIAS)
            ->select( self::ALIAS)
            ->orderBy(self::ALIAS . '.ref', 'ASC')
            ->addOrderBy(self::ALIAS. '.name','ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}
