<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findOneByUserIdAndUserAgentId($userId, $userAgentId): ?User
    {
        return $this->createQueryBuilder('u')
            ->innerJoin('u.uua', 'uua')
            ->addSelect('uua')
            ->andWhere('u.id = :userId')
            ->andWhere('uua.id = :userAgentId')
            ->setParameter('userId', $userId)
            ->setParameter('userAgentId', $userAgentId)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
            ;
    }

    public function findOneByUserIdAndProxyId($userId, $proxyId): ?User
    {
        return $this->createQueryBuilder('u')
            ->innerJoin('u.up', 'up')
            ->addSelect('up')
            ->andWhere('u.id = :userId')
            ->andWhere('up.id = :proxyId')
            ->setParameter('userId', $userId)
            ->setParameter('proxyId', $proxyId)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
            ;
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
