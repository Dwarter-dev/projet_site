<?php

namespace App\Repository;

use App\Entity\RegionProduit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RegionProduit|null find($id, $lockMode = null, $lockVersion = null)
 * @method RegionProduit|null findOneBy(array $criteria, array $orderBy = null)
 * @method RegionProduit[]    findAll()
 * @method RegionProduit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegionProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RegionProduit::class);
    }

    // /**
    //  * @return RegionProduit[] Returns an array of RegionProduit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RegionProduit
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
