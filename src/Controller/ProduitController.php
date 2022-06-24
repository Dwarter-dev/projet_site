<?php

namespace App\Controller;
// Entités/Classes
use App\Form\ProduitType;
use App\Entity\Produit;
use App\Repository\ProduitRepository;
// Fonctions
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
// Fonctionnement
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    // Partie Index
    #[Route('/admin/produit', name: 'admin_produit_index')]
    public function index(ProduitRepository $produitRepository): Response
    {
      $produits = $produitRepository->findAll();
      //dd($produits[0]->getLangueProduit()); // Test de la présence des données dans l'index
      return $this->render('produit/index.html.twig', [ // permet de transférer des données de la BDD en Twig
          'produits' => $produits,
      ]);
    }
    // Partie Création
    #[Route('/admin/produit/create', name: 'produit_create')]
    public function create(Request $request, ManagerRegistry $managerRegistry)
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $infoProduit = $form['imageProduit']->getData();
            $extensionProduit = $infoProduit->guessExtension();
            $nomProduit = time() . '-1.' . $extensionProduit;
            $infoProduit->move($this->getParameter('dossier_photos_produits'), $nomProduit);
            $produit->setimageProduit($nomProduit);

            $manager = $managerRegistry->getManager();
            $manager->persist($produit);
            $manager->flush();

            $this->addFlash('success', 'Le produit a bien été créer');
            return $this->redirectToRoute('admin_produit_index');
        }

        return $this->render('produit/produitForm.html.twig', [
            'produitForm' => $form->createView()
        ]);
    }
    //Partie Update
    #[Route('/admin/produit/update/{id}', name: 'produit_update')]
    public function update(ProduitRepository $produitRepository, int $id, Request $request, ManagerRegistry $managerRegistry)
    {
      $produit = $produitRepository->find($id); // Récupérer l'id et du coup la produit
      $form = $this->createForm(ProduitType::class, $produit); // Générer le formulaire en récupérant les données de le produit avec $produit
      $form->handleRequest($request); // gestionnaire de requêtes HTTP

      // Traitement si le formulaire est envoyé - Attention, avec le mapped, l'image ne se récupère pas
      if ($form->isSubmitted() && $form->isValid()) {

        // imageProduit
        // Si imageProduit dans form => supprime l'ancienne imageProduit =>génère le nom de l'imageProduit => upload de la nouvelle => setimageProduit
        $infoimageProduit = $form['imageProduit']->getData(); // récupère les informations de l'image 1
        $nomOldimageProduit = $produit->getimageProduit();

        if ($infoimageProduit !== null) { // si il y a une image dans le formulaire
          $cheminOldimageProduit = $this->getParameter('dossier_photos_produits') . '/' . $nomOldimageProduit; // On recompose le chemin de l'ancienne imageProduit en stockant l'ancien chemin dans une valeur différente
          if (file_exists($cheminOldimageProduit)) { //vérifie si le fichier existe
             unlink($cheminOldimageProduit); // Supprimer l'ancienne imageProduit
          }
          // Génère le nom de la nouvelle imageProduit
          $extensionimageProduit = $infoimageProduit->guessExtension(); // (Même que partie create)
          $nomimageProduit = time() . '-1.' . $extensionimageProduit;
          $infoimageProduit->move($this->getParameter('dossier_photos_produits'), $nomimageProduit);// upload de la nouvelle imageProduit
          $produit->setimageProduit($nomimageProduit); // setING1
        } else {
          $produit->setimageProduit($nomOldimageProduit); // sinon, on remet l'ancienne image avec l'ancien chemin
        }

        // Affichage de la form
        $manager = $managerRegistry->getManager();
        $manager->persist($produit);
        $manager->flush();
        $this->addFlash('success', 'Le produit a bien été modifier');
        return $this->redirectToRoute('admin_produit_index');
      }

      return $this->render('produit/produitForm.html.twig', [
        'produitForm' => $form->createView()
      ]);
    }

    // Partie Suppression
    #[Route('/admin/produits/delete/{id}', name: 'produit_delete')]
    public function delete(ProduitRepository $produitRepository, int $id, ManagerRegistry $managerRegistry)
    {
      // Récupérer le produit à partir de l'id
      $produit = $produitRepository->find($id); // récupère le produit graçe à son id
      $nomimageProduit = $produit->getimageProduit(); // récupère le nom de l'image1
      //dd($produit); // dd(...) → variant fonctionnel de var_dump qui charge à l'infini sur Symfony

      // Supprimer les images en vérifiant qu'il y a bien un nom d'image
      if ($nomimageProduit !==null) { // vérifie qu'il y a bien un nom d'image (et donc une image à supprimer)
          $cheminimageProduit = $this->getParameter('dossier_photos_produits') . '/' . $nomimageProduit; //reconstitue le chemin de l'image
          if (file_exists($cheminimageProduit)) { //vérifie si le fichier existe
             unlink($cheminimageProduit); // supprime le fichier
          }
      }

      // Envoie des valeurs
      $manager = $managerRegistry->getManager();
      $manager->remove($produit);
      $manager->flush();
      // Message de succès
      $this->addFlash('success', 'Le produit a bien été supprimé');
      // Redirection
      return $this->redirectToRoute('admin_produit_index');
    }
}
