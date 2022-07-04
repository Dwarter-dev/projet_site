<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// Mailer
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response // Request est la valeur qui stock les données envoyés
    {
        $form = $this->createForm(ContactType::class); // création du formulaire selon la base présente dans ContactType
        // note, ne pas oublier d'importer la/les class

        $form->handleRequest($request); // Récupère l'envoie des données de $request

        if ($form->isSubmitted() && $form->isValid()){ // Si le formulaire a été envoyé et les données sont valides

            $data = $form->getData(); // On récupère les données du formulaire

            //dd($data); // Test d'envoie du mail

            $email = (new Email())
                 ->from($data['email']) // l'adresse mail que je récupère dans le formulaire
                 ->to('admin@gmail.com') // l'adresse de l'admin
                 ->subject($data['subject'])
                 ->html($data['message']);

            $mailer->send($email); // envoir de l'email
            $this->addFlash('success', 'Votre message a bien été envoyé');
            return $this->redirectToRoute('app_contact');
        }

        return $this->renderForm('contact/index.html.twig', [
            'formulaire' => $form, // on pourra utiliser ce formulaire dans le template
            // formulaire = variable twig
            // $form = variable php
        ]);
    }
}
