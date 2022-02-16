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
  #[Route('/etat', name: 'admin_etat_index')]
  public function index(EtatProduitRepository $etatRepository): Response
  {
    $etats = $etatRepository->findAll();
    return $this->render('etat/index.html.twig', [
        'etat' => $etats,
    ]);
  }
  // Partie Création
  #[Route('/etat/create', name: 'etat_create')]
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
}
