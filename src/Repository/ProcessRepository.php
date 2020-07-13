<?php

namespace App\Repository;

use App\Entity\Process;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Process|null find($id, $lockMode = null, $lockVersion = null)
 * @method Process|null findOneBy(array $criteria, array $orderBy = null)
 * @method Process[]    findAll()
 * @method Process[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProcessRepository extends ServiceEntityRepository
{
    const ALIAS='p';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Process::class);
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

    public function findAllFillComboboxGrouping(string $id)
    {
        $builder = $this->createQueryBuilder(self::ALIAS)
            ->select('distinct '.self::ALIAS.'.grouping as id ,'. self::ALIAS.'.grouping as name');

        $builder = $builder
            ->Where(self::ALIAS.'.mProcess = :val1')
            ->andWhere(self::ALIAS.'.grouping != :gp')
            ->setParameters(['val1'=> $id,'gp'=> ""])
            ->orderBy(self::ALIAS.'.grouping', 'ASC');

        return $builder
            ->getQuery()
            ->getResult();
    }
}
