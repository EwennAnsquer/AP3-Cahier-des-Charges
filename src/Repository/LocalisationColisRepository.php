<?php

namespace App\Repository;

use App\Entity\LocalisationColis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LocalisationColis>
 *
 * @method LocalisationColis|null find($id, $lockMode = null, $lockVersion = null)
 * @method LocalisationColis|null findOneBy(array $criteria, array $orderBy = null)
 * @method LocalisationColis[]    findAll()
 * @method LocalisationColis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocalisationColisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LocalisationColis::class);
    }

//    /**
//     * @return LocalisationColis[] Returns an array of LocalisationColis objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LocalisationColis
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
