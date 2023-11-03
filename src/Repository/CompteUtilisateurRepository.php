<?php

namespace App\Repository;

use App\Entity\CompteUtilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompteUtilisateur>
 *
 * @method CompteUtilisateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompteUtilisateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompteUtilisateur[]    findAll()
 * @method CompteUtilisateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompteUtilisateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompteUtilisateur::class);
    }

//    /**
//     * @return CompteUtilisateur[] Returns an array of CompteUtilisateur objects
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

//    public function findOneBySomeField($value): ?CompteUtilisateur
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
