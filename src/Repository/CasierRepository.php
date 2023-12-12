<?php

namespace App\Repository;

use App\Entity\Casier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Casier>
 *
 * @method Casier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Casier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Casier[]    findAll()
 * @method Casier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CasierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Casier::class);
    }

//    /**
//     * @return Casier[] Returns an array of Casier objects
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

//    public function findOneBySomeField($value): ?Casier
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
