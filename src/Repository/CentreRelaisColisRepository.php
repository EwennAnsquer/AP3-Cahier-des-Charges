<?php

namespace App\Repository;

use App\Entity\CentreRelaisColis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CentreRelaisColis>
 *
 * @method CentreRelaisColis|null find($id, $lockMode = null, $lockVersion = null)
 * @method CentreRelaisColis|null findOneBy(array $criteria, array $orderBy = null)
 * @method CentreRelaisColis[]    findAll()
 * @method CentreRelaisColis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CentreRelaisColisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CentreRelaisColis::class);
    }

//    /**
//     * @return CentreRelaisColis[] Returns an array of CentreRelaisColis objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CentreRelaisColis
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
