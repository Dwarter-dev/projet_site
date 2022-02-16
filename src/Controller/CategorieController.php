<?php

namespace App\Controller;
// Entités/Classes
use App\Form\CategorieType;
use App\Entity\CategorieProduit;
use App\Repository\CategorieProduitRepository;
// Fonctions
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
// Fonctionnement
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
  #[Route('/categorie', name: 'admin_categorie_index')]
  public function index(CategorieProduitRepository $categorieRepository): Response
  {
    $categories = $categorieRepository->findAll();
    return $this->render('categorie/index.html.twig', [
        'categorie' => $categories,
    ]);
  }
  // Partie Création
  #[Route('/categorie/create', name: 'categorie_create')]
  public function create(Request $request, ManagerRegistry $managerRegistry)
  {
      $categorie = new CategorieProduit();
      $form = $this->createForm(CategorieType::class, $categorie);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
          $manager = $managerRegistry->getManager();
          $manager->persist($categorie);
          $manager->flush();

          $this->addFlash('success', 'La categorie a bien été créer');
          return $this->redirectToRoute('admin_categorie_index');
      }

      return $this->render('categorie/categorieForm.html.twig', [
          'categorieForm' => $form->createView()
      ]);
  }
}
