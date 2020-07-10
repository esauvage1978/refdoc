<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    const ALIAS = 'u';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findAllForAdmin()
    {
        return $this->createQueryBuilder(self::ALIAS)
            ->select(
                self::ALIAS
            )
            ->orderBy(self::ALIAS . '.name', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function findAllForContactGestionnaire()
    {
        return $this->createQueryBuilder(self::ALIAS)
            ->Where(self::ALIAS.'.roles like :val1')
            ->AndWhere(self::ALIAS.'.roles not like :val2')
            ->setParameter('val1', '%"ROLE_GESTIONNAIRE"%')
            ->setParameter('val2', '%ROLE_ADMIN%')
            ->orderBy(self::ALIAS.'.name', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
    /**
     * @return User[] Returns an array of User objects
     */
    public function findAllForContactAdmin()
    {
        return $this->createQueryBuilder(self::ALIAS)
            ->Where(self::ALIAS.'.roles like :val1')
            ->setParameter('val1', '%ROLE_ADMIN%')
            ->orderBy(self::ALIAS.'.name', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllUserSubscription()
    {
        return $this->createQueryBuilder(self::ALIAS)
            ->select(
                self::ALIAS
            )
            ->where(self::ALIAS.'.isEnable=true')
            ->andWhere(self::ALIAS.'.subscription=true')
            ->andWhere(self::ALIAS.'.emailValidated=true')
            ->orderBy(self::ALIAS . '.name', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

}
