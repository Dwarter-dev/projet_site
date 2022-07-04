<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    // /**
    //  * @return Produit[] Returns an array of Produit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    /**
    * @return Produit[] Returns an array of 1 Produit objects ordered by latest insted id
    */
    public function findById()
    {
        return $this->createQueryBuilder('fls') // fls est un alias
        ->orderBy('fls.id', 'DESC') // DESC : tri en ordre décroissant - ASC : tri en ordre croissant 
        ->setMaxResults(2) // sélectionne 2 résultats maximum
        ->getQuery() // requête
        ->getResult(); // résultats(s)
    }
    public function findByPrice()
    {
        return $this->createQueryBuilder('flsprice')
        ->orderBy('flsprice.prix_produit', 'DESC') // ou ASC
        ->getQuery()
        ->getResult(); 
    }
    public function findByEtat()
    {
        return $this->createQueryBuilder('flsprice')
        ->orderBy('flsprice.langue_produit') 
        ->getQuery()
        ->getResult(); 
    }
}
