<?php

namespace App\Repository;

use App\Entity\SoftwareExtras;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SoftwareExtras|null find($id, $lockMode = null, $lockVersion = null)
 * @method SoftwareExtras|null findOneBy(array $criteria, array $orderBy = null)
 * @method SoftwareExtras[]    findAll()
 * @method SoftwareExtras[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SoftwareExtrasRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SoftwareExtras::class);
    }

//    /**
//     * @return SoftwareExtras[] Returns an array of SoftwareExtras objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SoftwareExtras
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
