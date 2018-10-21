<?php

namespace App\Repository;

use App\Entity\UUA;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UUA|null find($id, $lockMode = null, $lockVersion = null)
 * @method UUA|null findOneBy(array $criteria, array $orderBy = null)
 * @method UUA[]    findAll()
 * @method UUA[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UUARepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UUA::class);
    }

//    /**
//     * @return UUA[] Returns an array of UUA objects
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
    public function findOneBySomeField($value): ?UUA
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
