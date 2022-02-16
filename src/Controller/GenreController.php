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
    return $this->render('genre/index.html.twig', [
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

      return $this->render('genre/genreForm.html.twig', [
          'genreForm' => $form->createView()
      ]);
  }
}
