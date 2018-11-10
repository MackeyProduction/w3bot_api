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

    public function findOneBySoftwareNameAndVersion($softwareName, $version): ?UserAgent
    {
        return $this->createQueryBuilder('ua')
            ->innerJoin('ua.software', 's')
            ->addSelect('s')
            ->innerJoin('s.softwareName', 'sn')
            ->addSelect('sn')
            ->andWhere('sn.name = :softwareName')
            ->andWhere('s.version = :version')
            ->setParameter('softwareName', $softwareName)
            ->setParameter('version', $version)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function findOneByLayoutEngineAndVersion($layoutEngineName, $version): ?UserAgent
    {
        return $this->createQueryBuilder('ua')
            ->innerJoin('ua.software', 's')
            ->addSelect('s')
            ->innerJoin('s.layoutEngine', 'le')
            ->addSelect('le')
            ->andWhere('le.name = :layoutEngineName')
            ->andWhere('s.LeVersion = :version')
            ->setParameter('layoutEngineName', $layoutEngineName)
            ->setParameter('version', $version)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function findOneByOperatingSystemNameAndVersion($osName, $version): ?UserAgent
    {
        return $this->createQueryBuilder('ua')
            ->innerJoin('ua.operatingSystem', 'o')
            ->addSelect('o')
            ->innerJoin('o.operatingSystemName', 'osn')
            ->addSelect('osn')
            ->andWhere('osn.name = :operatingSystemName')
            ->andWhere('o.version = :version')
            ->setParameter('operatingSystemName', $osName)
            ->setParameter('version', $version)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
            ;
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
