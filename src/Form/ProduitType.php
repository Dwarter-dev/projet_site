<?php

namespace App\Form;
// Entités/Classes
use App\Entity\Produit;
use App\Entity\GenreProduit;
use App\Entity\LangueProduit;
use App\Entity\RegionProduit;
use App\Entity\EtatProduit;
use App\Entity\CategorieProduit;
// Fonctions
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
// Fonctionnement
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_produit', TextType::class, [
                'required' => true,
                'label' => 'Nom du produit',
                'attr' => [
                     'maxLenght' => 100,
                     'placeholder' => 'Super Mario Bros.'
                ]
              ])
            ->add('description_produit', TextareaType::class, [
                'required' => true,
                'label' => 'Description',
                'attr' => [
                     'maxLenght' => 65535,
                     'placeholder' => 'Détails en tout genre sur le jeu'
                ]
              ])
            ->add('nb_manette_produit', ChoiceType::class, [
                //'required' => true,
                'label' => 'Nbr de Manettes',
                'choices' => [
                    '0' => 0,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    '7' => 7,
                    '8' => 8
                ]
              ])
            ->add('branchement_produit', ChoiceType::class, [ // booléen
                'required' => true,
                'label' => 'Branchements',
                'choices' => [
                  '-- sélectionner une option --' => null,
                  'oui' => true,
                  'non' => false
                ]
              ])
            ->add('boite_produit', ChoiceType::class, [ // booléen
                'required' => true,
                'label' => 'Branchements',
                'choices' => [
                  '-- sélectionner une option --' => null,
                  'oui' => true,
                  'non' => false
                ]
              ])
            ->add('notice_produit', ChoiceType::class, [
                'required' => true,
                'label' => 'Notice',
                'choices' => [
                  '-- sélectionner une option --' => null,
                  'oui' => true,
                  'non' => false
                ]
              ])
            ->add('prixProduit', IntegerType::class, [
                //'required' => true,
                'label' => 'Prix (€)',
                'attr' => [
                    'min' => 0,
                    'max' => 9999,
                    'placeholder' => '50'
              ]
            ])
            ->add('imageProduit', FileType::class, [
              // le souci principal : FileType enverra l'image dans la BDD -> conflit avec la récupération à partir de twig
                'required' => true,
                'label' => 'Image du produit',
                'help' => '.png, .jpg, .jpeg, .jp2 ou .webp - 1 Mo maximum',
                'mapped' => false,
                // dissocie ce qu'il y a dans le formulaire de ce qui est présent dans la BDD
                // empêche d'envoyer l'image et envoie uniquement le nom de l'image pour que la BDD stocke un texte à la place d'une image
                'constraints' => [ //contraintes d'envoie du fichier
                    new Image ([
                        'maxSize' => '1M', // Taille (1Mo)
                        'maxSizeMessage' => 'Le fichier est trop volumineux ({{ size }} Mo). Taille maximum : 1 Mo',
                        'mimeTypes' => [ // type
                          'image/png',
                          'image/jpg',
                          'image/jpeg',
                          'image/jp2',
                          'image/webp',
                        ],
                        'mimeTypesMessage' => 'Merci de sélectionner un format dans cette liste : .PNG, .JPG, .JPEG, .JP2 ou .WEBP'
                    ])
                  ]
            ])
            //Importation des différentes Classes/Entités lié à la table Produit [à trouver]
            ->add('genreProduit', EntityType::class, [
                'class' => GenreProduit::class,
                'choice_label' => 'nom_genre',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('langueProduit', EntityType::class, [
                'class' => LangueProduit::class,
                'choice_label' => 'nom_langue',
                'multiple' => true,

            ])
            ->add('regionProduit', EntityType::class, [
                'class' => RegionProduit::class,
                'choice_label' => 'nom_region'
            ])
            ->add('etatProduit', EntityType::class, [
                'required' => true,
                'class' => EtatProduit::class,
                'choice_label' => 'nom_etat'
            ])
            ->add('categorieProduit', EntityType::class, [
                'class' => CategorieProduit::class,
                'choice_label' => 'nom_categorie'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
