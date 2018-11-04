<?php

namespace App\Repository;

use App\Entity\LayoutEngine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LayoutEngine|null find($id, $lockMode = null, $lockVersion = null)
 * @method LayoutEngine|null findOneBy(array $criteria, array $orderBy = null)
 * @method LayoutEngine[]    findAll()
 * @method LayoutEngine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LayoutEngineRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LayoutEngine::class);
    }

//    /**
//     * @return LayoutEngine[] Returns an array of LayoutEngine objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LayoutEngine
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
