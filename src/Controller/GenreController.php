<?php

namespace App\Controller;
// Entités/Classes
use App\Form\GenreType;
use App\Entity\GenreProduit;
use App\Repository\GenreProduitRepository;
// Fonctions
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
// Fonctionnement
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenreController extends AbstractController
{
  #[Route('/admin/genre', name: 'admin_genre_index')]
  public function index(GenreProduitRepository $genreRepository): Response
  {
    $genres = $genreRepository->findAll();
    return $this->render('admin/genre/index.html.twig', [
        'genre' => $genres,
    ]);
  }
  // Partie Création
  #[Route('/admin/genre/create', name: 'genre_create')]
  public function create(Request $request, ManagerRegistry $managerRegistry)
  {
      $genre = new GenreProduit();
      $form = $this->createForm(GenreType::class, $genre);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
          $manager = $managerRegistry->getManager();
          $manager->persist($genre);
          $manager->flush();

          $this->addFlash('success', 'Le genre a bien été créer');
          return $this->redirectToRoute('admin_genre_index');
      }

      return $this->render('admin/genre/genreForm.html.twig', [
          'genreForm' => $form->createView()
      ]);
  }
  //Partie Update
   #[Route('/admin/genre/update/{id}', name: 'genre_update')]
   public function update(GenreProduitRepository $genreRepository, int $id, Request $request, ManagerRegistry $managerRegistry)
   {
     $genre = $genreRepository->find($id); // Récupérer l'id et du coup la genre
     $form = $this->createForm(GenreType::class, $genre); // Générer le formulaire en récupérant les données de la genre avec $genre
     $form->handleRequest($request); // gestionnaire de requêtes HTTP

     // Traitement si le formulaire est envoyé - Attention, avec le mapped, l'image ne se récupère pas
     if ($form->isSubmitted() && $form->isValid()) {
       // Affichage de la form
       $manager = $managerRegistry->getManager();
       $manager->persist($genre);
       $manager->flush();

       $this->addFlash('success', 'Le genre a bien été modifier');
       return $this->redirectToRoute('admin_genre_index');
     }

     return $this->render('admin/genre/genreUpdateForm.html.twig', [
       'genreForm' => $form->createView()
     ]);
   }
   // Partie Suppression
   #[Route('/admin/genre/delete/{id}', name: 'genre_delete')]
   public function delete(GenreProduitRepository $genreRepository, int $id, ManagerRegistry $managerRegistry)
   {
     // Récupérer la genre à partir de l'id
     $genre = $genreRepository->find($id); // récupère la genre graçe à son id
     // Récupération et suppression des valeurs
     $manager = $managerRegistry->getManager();
     $manager->remove($genre);
     $manager->flush();
     // Message de succès
     $this->addFlash('success', 'Le genre a bien été supprimé');
     // Redirection
     return $this->redirectToRoute('admin_genre_index');
   }
}
