<?php

namespace App\Repository;

use App\Entity\LangueProduit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LangueProduit|null find($id, $lockMode = null, $lockVersion = null)
 * @method LangueProduit|null findOneBy(array $criteria, array $orderBy = null)
 * @method LangueProduit[]    findAll()
 * @method LangueProduit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LangueProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LangueProduit::class);
    }

    // /**
    //  * @return LangueProduit[] Returns an array of LangueProduit objects
    //  */
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
    public function findOneBySomeField($value): ?LangueProduit
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
