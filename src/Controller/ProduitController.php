<?php

namespace App\Controller;
// Entités/Classes
use App\Form\ProduitType;
use App\Entity\Produit;
use App\Repository\ProduitRepository;
// Fonctions
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
// Fonctionnement
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    #[Route('/admin/produit', name: 'admin_produit_index')]
    public function index(ProduitRepository $produitRepository): Response
    {
      $produits = $produitRepository->findAll();
      return $this->render('produit/index.html.twig', [
          'produit' => $produits,
      ]);
    }
    // Partie Création
    #[Route('/admin/produit/create', name: 'produit_create')]
    public function create(Request $request, ManagerRegistry $managerRegistry)
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $infoimage_produit = $form['image_produit']->getData();
            $extensionimage_produit = $infoimage_produit->guessExtension();
            $nomimage_produit = time() . '-1.' . $extensionimage_produit;
            $infoimage_produit->move($this->getParameter('dossier_photos_produits'), $nomimage_produit);
            $produit->setimage_produit($nomimage_produit);

            $manager = $managerRegistry->getManager();
            $manager->persist($produit);
            $manager->flush();

            $this->addFlash('success', 'La produit a bien été créer');
            return $this->redirectToRoute('admin_produit_index');
        }

        return $this->render('produit/produitForm.html.twig', [
            'produitForm' => $form->createView()
        ]);
    }
}
