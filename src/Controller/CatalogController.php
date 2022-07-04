<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitRepository; // on récupère le répertoire de produit pour les entités produits

class CatalogController extends AbstractController
{
    #[Route('/catalogue', name: 'app_catalog')]
    public function index(ProduitRepository $produitRepository): Response // puis on l'intègre dans la fonction
    {
        //$produits = $produitRepository->findAll(); // Récupérer toute la liste des produits

        /*$produits = $produitRepository->findBy( // rechercher un ou plusieurs produits avec un ou plusieurs paramètres
        ['branchement_produit'=>'0'], // récupérer une valeur dans la table Produit
        );*/

        // Pour trier selon un ordre précis, voir ProduitRepository.php
        //$produits = $produitRepository->findById(); // pour trier un nombre précis de produits avec l'id
        //$produits = $produitRepository->findByPrice(); // pour trier dans l'ordre corissant/décroissant le prix
        $produits = $produitRepository->findByEtat();
        /*$produits = $produitRepository->findBy(....): rechercher un seul produit avec un ou plusieurs paramètres

        $produits = $produitRepository->find($id): rechercher un produit par son id
        */

        return $this->render('catalog/index.html.twig', [
            'controller_name' => 'CatalogController',
            'produits' => $produits // utilisable dans le twig
        ]);
    }
}
