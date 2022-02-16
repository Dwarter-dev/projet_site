<?php

namespace App\Controller;
// Entités/Classes
use App\Form\EtatType;
use App\Entity\EtatProduit;
use App\Repository\EtatProduitRepository;
// Fonctions
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
// Fonctionnement
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtatController extends AbstractController
{
  #[Route('/admin/etat', name: 'admin_etat_index')]
  public function index(EtatProduitRepository $etatRepository): Response
  {
    $etats = $etatRepository->findAll();
    return $this->render('etat/index.html.twig', [
        'etat' => $etats,
    ]);
  }
  // Partie Création
  #[Route('/admin/etat/create', name: 'etat_create')]
  public function create(Request $request, ManagerRegistry $managerRegistry)
  {
      $etat = new EtatProduit();
      $form = $this->createForm(EtatType::class, $etat);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
          $manager = $managerRegistry->getManager();
          $manager->persist($etat);
          $manager->flush();

          $this->addFlash('success', 'L\'etat a bien été créer');
          return $this->redirectToRoute('admin_etat_index');
      }

      return $this->render('etat/etatForm.html.twig', [
          'etatForm' => $form->createView()
      ]);
   }
   //Partie Update
    #[Route('/admin/etat/update/{id}', name: 'etat_update')]
    public function update(EtatProduitRepository $etatRepository, int $id, Request $request, ManagerRegistry $managerRegistry)
    {
      $etat = $etatRepository->find($id); // Récupérer l'id et du coup la etat
      $form = $this->createForm(EtatType::class, $etat); // Générer le formulaire en récupérant les données de la etat avec $etat
      $form->handleRequest($request); // gestionnaire de requêtes HTTP

      // Traitement si le formulaire est envoyé - Attention, avec le mapped, l'image ne se récupère pas
      if ($form->isSubmitted() && $form->isValid()) {
        // Affichage de la form
        $manager = $managerRegistry->getManager();
        $manager->persist($etat);
        $manager->flush();

        $this->addFlash('success', 'L\'etat a bien été modifier');
        return $this->redirectToRoute('admin_etat_index');
      }

      return $this->render('etat/etatUpdateForm.html.twig', [
        'etatForm' => $form->createView()
      ]);
    }
    // Partie Suppression
    #[Route('/admin/etat/delete/{id}', name: 'etat_delete')]
    public function delete(EtatProduitRepository $categorieRepository, int $id, ManagerRegistry $managerRegistry)
    {
      // Récupérer la etat à partir de l'id
      $etat = $categorieRepository->find($id); // récupère la etat graçe à son id
      // Récupération et suppression des valeurs
      $manager = $managerRegistry->getManager();
      $manager->remove($etat);
      $manager->flush();
      // Message de succès
      $this->addFlash('success', 'L\'etat a bien été supprimé');
      // Redirection
      return $this->redirectToRoute('admin_etat_index');
    }
}
