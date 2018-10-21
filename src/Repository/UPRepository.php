<?php

namespace App\Repository;

use App\Entity\UP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UP|null find($id, $lockMode = null, $lockVersion = null)
 * @method UP|null findOneBy(array $criteria, array $orderBy = null)
 * @method UP[]    findAll()
 * @method UP[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UPRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UP::class);
    }

//    /**
//     * @return UP[] Returns an array of UP objects
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
    public function findOneBySomeField($value): ?UP
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
