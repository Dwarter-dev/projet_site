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
  #[Route('/admin/categorie', name: 'admin_categorie_index')]
  public function index(CategorieProduitRepository $categorieRepository): Response
  {
    $categories = $categorieRepository->findAll();
    return $this->render('admin/categorie/index.html.twig', [
        'categorie' => $categories,
    ]);
  }
  // Partie Création
  #[Route('/admin/categorie/create', name: 'categorie_create')]
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

      return $this->render('admin/categorie/categorieForm.html.twig', [
          'categorieForm' => $form->createView()
      ]);
  }
  //Partie Update
   #[Route('/admin/categorie/update/{id}', name: 'categorie_update')]
   public function update(CategorieProduitRepository $categorieRepository, int $id, Request $request, ManagerRegistry $managerRegistry)
   {
     $categorie = $categorieRepository->find($id); // Récupérer l'id et du coup la categorie
     $form = $this->createForm(CategorieType::class, $categorie); // Générer le formulaire en récupérant les données de la categorie avec $categorie
     $form->handleRequest($request); // gestionnaire de requêtes HTTP

     // Traitement si le formulaire est envoyé - Attention, avec le mapped, l'image ne se récupère pas
     if ($form->isSubmitted() && $form->isValid()) {
       // Affichage de la form
       $manager = $managerRegistry->getManager();
       $manager->persist($categorie);
       $manager->flush();

       $this->addFlash('success', 'La région a bien été modifier');
       return $this->redirectToRoute('admin_categorie_index');
     }

     return $this->render('admin/categorie/categorieUpdateForm.html.twig', [
       'categorieForm' => $form->createView()
     ]);
   }
   // Partie Suppression
   #[Route('/admin/categorie/delete/{id}', name: 'categorie_delete')]
   public function delete(CategorieProduitRepository $categorieRepository, int $id, ManagerRegistry $managerRegistry)
   {
     // Récupérer la categorie à partir de l'id
     $categorie = $categorieRepository->find($id); // récupère la categorie graçe à son id
     // Récupération et suppression des valeurs
     $manager = $managerRegistry->getManager();
     $manager->remove($categorie);
     $manager->flush();
     // Message de succès
     $this->addFlash('success', 'La categorie a bien été supprimé');
     // Redirection
     return $this->redirectToRoute('admin_categorie_index');
   }
}
