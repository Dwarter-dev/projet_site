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
  //Partie Update
   #[Route('/admin/langue/update/{id}', name: 'langue_update')]
   public function update(LangueProduitRepository $langueRepository, int $id, Request $request, ManagerRegistry $managerRegistry)
   {
     $langue = $langueRepository->find($id); // Récupérer l'id et du coup la langue
     $form = $this->createForm(LangueType::class, $langue); // Générer le formulaire en récupérant les données de la langue avec $langue
     $form->handleRequest($request); // gestionnaire de requêtes HTTP

     // Traitement si le formulaire est envoyé - Attention, avec le mapped, l'image ne se récupère pas
     if ($form->isSubmitted() && $form->isValid()) {
       // Affichage de la form
       $manager = $managerRegistry->getManager();
       $manager->persist($langue);
       $manager->flush();

       $this->addFlash('success', 'La région a bien été modifier');
       return $this->redirectToRoute('admin_langue_index');
     }

     return $this->render('langue/langueUpdateForm.html.twig', [
       'langueForm' => $form->createView()
     ]);
   }
   // Partie Suppression
   #[Route('/admin/langue/delete/{id}', name: 'langue_delete')]
   public function delete(LangueProduitRepository $langueRepository, int $id, ManagerRegistry $managerRegistry)
   {
     // Récupérer la langue à partir de l'id
     $langue = $langueRepository->find($id); // récupère la langue graçe à son id
     // Récupération et suppression des valeurs
     $manager = $managerRegistry->getManager();
     $manager->remove($langue);
     $manager->flush();
     // Message de succès
     $this->addFlash('success', 'La langue a bien été supprimé');
     // Redirection
     return $this->redirectToRoute('admin_langue_index');
   }
}
