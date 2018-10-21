<?php

namespace App\Repository;

use App\Entity\UserAgent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserAgent|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserAgent|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserAgent[]    findAll()
 * @method UserAgent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserAgentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserAgent::class);
    }

//    /**
//     * @return UserAgent[] Returns an array of UserAgent objects
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
    public function findOneBySomeField($value): ?UserAgent
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
