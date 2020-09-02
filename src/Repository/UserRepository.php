<?php

declare(strict_types=1);

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
    public const ALIAS = 'u';
    public const ALIAS_MP_DV = 'u_mp_dv';
    public const ALIAS_MP_PV = 'u_mp_pv';
    public const ALIAS_MP_C = 'u_mp_c';
    public const ALIAS_P_V = 'u_p_v';
    public const ALIAS_P_C = 'u_p_c';

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
            ->getResult();
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function findAllForContactGestionnaire(): array
    {
        return $this->createQueryBuilder(self::ALIAS)
            ->Where(self::ALIAS . '.roles like :val1')
            ->OrWhere(self::ALIAS . '.roles like :val2')
            ->setParameter('val1', '%"ROLE_GESTIONNAIRE"%')
            ->setParameter('val2', '%ROLE_ADMIN%')
            ->orderBy(self::ALIAS . '.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function findAllForContactUtilisateur(): array
    {
        return $this->createQueryBuilder(self::ALIAS)
            ->Where(self::ALIAS . '.roles like :val1')
            ->OrWhere(self::ALIAS . '.roles like :val2')
            ->OrWhere(self::ALIAS . '.roles like :val3')
            ->setParameters([
                'val1' => '%"ROLE_GESTIONNAIRE"%',
                'val2' => '%ROLE_ADMIN%',
                'val3' => '%"ROLE_USER"%',
            ])
            ->orderBy(self::ALIAS . '.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function findAllForContactAdmin(): array
    {
        return $this->createQueryBuilder(self::ALIAS)
            ->Where(self::ALIAS . '.roles like :val1')
            ->setParameter('val1', '%ROLE_ADMIN%')
            ->orderBy(self::ALIAS . '.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function findAllForContactIsDoc(): array
    {
        return $this->createQueryBuilder(self::ALIAS)
            ->Where(self::ALIAS . '.isDoc like :val1')
            ->setParameter('val1', '1')
            ->orderBy(self::ALIAS . '.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function findAllForContactIsControl(): array
    {
        return $this->createQueryBuilder(self::ALIAS)
            ->Where(self::ALIAS . '.isControl like :val1')
            ->setParameter('val1', '1')
            ->orderBy(self::ALIAS . '.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findAllUserSubscription()
    {
        return $this->createQueryBuilder(self::ALIAS)
            ->select(
                self::ALIAS
            )
            ->where(self::ALIAS . '.isEnable=true')
            ->andWhere(self::ALIAS . '.subscription=true')
            ->andWhere(self::ALIAS . '.emailValidated=true')
            ->orderBy(self::ALIAS . '.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
