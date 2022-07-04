<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
//use Doctrine\ORM\Query\Expr\Join;
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
    * @return Produit[] Retourne un tableau de 1 Produit objet ordonné par la dernière unstance d'id
    */
    public function findById() // CatalogController.php
    {
        return $this->createQueryBuilder('fls') // fls est un alias
        ->orderBy('fls.id', 'DESC') // DESC : tri en ordre décroissant - ASC : tri en ordre croissant
        ->setMaxResults(2) // paramètre qui sélectionne 2 résultats maximum
        ->getQuery() // envoie de la requête
        ->getResult(); // résultat(s)
    }
    public function findByPrice()
    {
        return $this->createQueryBuilder('flsprice')
        ->orderBy('flsprice.prix_produit', 'DESC') // de A à Z ou DESC : de Z à A
        ->getQuery()
        ->getResult();
    }
    // public function findByGenre() // (ou langue) Dilème des relations ManyToMany
    // {
    //     return $this->createQueryBuilder('fls') // Tentative avec un inner join, mais impossible
    //     ->select('langue_produit') // le problème : aucune donnée direct est écrite sur la table produit
    //     ->from('App:Produit', 'lp') // donc rien ne marche après
    //     ->orderBy('fls.lp', 'DESC') // au delà de ce que j'ai vu pour le moment ou gérer autrement
    //     ->getQuery()
    //     ->getResult();
    // }
}
