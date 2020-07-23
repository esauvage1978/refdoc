<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Subscription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Subscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subscription[]    findAll()
 * @method Subscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubscriptionRepository extends ServiceEntityRepository
{
    public const ALIAS = 's';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subscription::class);
    }

    public function findAllSubscription(string $id)
    {
        $builder = $this->createQueryBuilder(self::ALIAS)
            ->select(self::ALIAS, MProcessRepository::ALIAS, ProcessRepository::ALIAS)
            ->leftJoin(self::ALIAS . '.mProcess', MProcessRepository::ALIAS)
            ->leftJoin(self::ALIAS . '.process', ProcessRepository::ALIAS)
            ->Where(self::ALIAS . '.user != :u')
            ->setParameters(['u' => $id]);

        return $builder
            ->getQuery()
            ->getResult();
    }
}
