<?php

namespace App\Controller;
// Entités/Classes
use App\Form\RegionType;
use App\Entity\RegionProduit;
use App\Repository\RegionProduitRepository;
// Fonctions
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
// Fonctionnement
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegionController extends AbstractController
{
  #[Route('/admin/region', name: 'admin_region_index')]
  public function index(RegionProduitRepository $regionRepository): Response
  {
    $regions = $regionRepository->findAll();
    return $this->render('admin/region/index.html.twig', [
        'region' => $regions,
    ]);
  }
  // Partie Création
  #[Route('/admin/region/create', name: 'region_create')]
  public function create(Request $request, ManagerRegistry $managerRegistry)
  {
      $region = new RegionProduit();
      $form = $this->createForm(RegionType::class, $region);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
          $manager = $managerRegistry->getManager();
          $manager->persist($region);
          $manager->flush();

          $this->addFlash('success', 'La région a bien été créer');
          return $this->redirectToRoute('admin_region_index');
      }

      return $this->render('admin/region/regionForm.html.twig', [
          'regionForm' => $form->createView()
      ]);
   }
   //Partie Update
    #[Route('/admin/region/update/{id}', name: 'region_update')]
    public function update(RegionProduitRepository $regionRepository, int $id, Request $request, ManagerRegistry $managerRegistry)
    {
      $region = $regionRepository->find($id); // Récupérer l'id et du coup la region
      $form = $this->createForm(RegionType::class, $region); // Générer le formulaire en récupérant les données de la region avec $region
      $form->handleRequest($request); // gestionnaire de requêtes HTTP

      // Traitement si le formulaire est envoyé - Attention, avec le mapped, l'image ne se récupère pas
      if ($form->isSubmitted() && $form->isValid()) {
        // Affichage de la form
        $manager = $managerRegistry->getManager();
        $manager->persist($region);
        $manager->flush();

        $this->addFlash('success', 'La région a bien été modifier');
        return $this->redirectToRoute('admin_region_index');
      }

      return $this->render('admin/region/regionUpdateForm.html.twig', [
        'regionForm' => $form->createView()
      ]);
    }
    // Partie Suppression
    #[Route('/admin/region/delete/{id}', name: 'region_delete')]
    public function delete(RegionProduitRepository $regionRepository, int $id, ManagerRegistry $managerRegistry)
    {
      // Récupérer la region à partir de l'id
      $region = $regionRepository->find($id); // récupère la region graçe à son id
      // Récupération et suppression des valeurs
      $manager = $managerRegistry->getManager();
      $manager->remove($region);
      $manager->flush();
      // Message de succès
      $this->addFlash('success', 'La region a bien été supprimé');
      // Redirection
      return $this->redirectToRoute('admin_region_index');
    }
}
