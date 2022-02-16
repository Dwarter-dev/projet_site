<?php

namespace App\Controller;
// Entités/Classes
use App\Form\LangueType;
use App\Entity\LangueProduit;
use App\Repository\LangueProduitRepository;
// Fonctions
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
// Fonctionnement
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LangueController extends AbstractController
{
  #[Route('/admin/langue', name: 'admin_langue_index')]
  public function index(LangueProduitRepository $langueRepository): Response
  {
    $langues = $langueRepository->findAll();
    return $this->render('langue/index.html.twig', [
        'langue' => $langues,
    ]);
  }
  // Partie Création
  #[Route('/admin/langue/create', name: 'langue_create')]
  public function create(Request $request, ManagerRegistry $managerRegistry)
  {
      $langue = new LangueProduit();
      $form = $this->createForm(LangueType::class, $langue);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
          $manager = $managerRegistry->getManager();
          $manager->persist($langue);
          $manager->flush();

          $this->addFlash('success', 'Le langue a bien été créer');
          return $this->redirectToRoute('admin_langue_index');
      }

      return $this->render('langue/langueForm.html.twig', [
          'langueForm' => $form->createView()
      ]);
  }
}
