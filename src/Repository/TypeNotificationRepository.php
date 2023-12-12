<?php

namespace App\Repository;

use App\Entity\TypeNotification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeNotification>
 *
 * @method TypeNotification|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeNotification|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeNotification[]    findAll()
 * @method TypeNotification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeNotificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeNotification::class);
    }

//    /**
//     * @return TypeNotification[] Returns an array of TypeNotification objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TypeNotification
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
