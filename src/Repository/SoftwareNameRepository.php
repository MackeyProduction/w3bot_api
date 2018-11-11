<?php

namespace App\Repository;

use App\Entity\SoftwareName;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SoftwareName|null find($id, $lockMode = null, $lockVersion = null)
 * @method SoftwareName|null findOneBy(array $criteria, array $orderBy = null)
 * @method SoftwareName[]    findAll()
 * @method SoftwareName[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SoftwareNameRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SoftwareName::class);
    }

//    /**
//     * @return SoftwareName[] Returns an array of SoftwareName objects
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
    public function findOneBySomeField($value): ?SoftwareName
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
