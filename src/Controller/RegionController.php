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
    return $this->render('region/index.html.twig', [
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

          $this->addFlash('success', 'Le region a bien été créer');
          return $this->redirectToRoute('admin_region_index');
      }

      return $this->render('region/regionForm.html.twig', [
          'regionForm' => $form->createView()
      ]);
   }
}
