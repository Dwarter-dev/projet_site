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
            ->add('nomProduit', TextType::class, [
                'required' => true,
                'label' => 'Nom du produit',
                'attr' => [
                     'maxLenght' => 100,
                     'placeholder' => 'Super Mario Bros.'
                ]
              ])
            ->add('descriptionProduit', TextareaType::class, [
                'required' => true,
                'label' => 'Description',
                'attr' => [
                     'maxLenght' => 65535,
                     'placeholder' => 'Détails en tout genre sur le jeu'
                ]
              ])
            ->add('nbManetteProduit', ChoiceType::class, [
                //'required' => true,
                'label' => 'Nbr de Manettes',
                'choices' => [
                    'Aucune' => 0,
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
            ->add('branchementProduit', ChoiceType::class, [
                'label' => 'Branchements',
                'choices' => [
                  'Aucun' => false,
                  'Inclus' => true
                ]
              ])
            ->add('boiteProduit', ChoiceType::class, [ // booléen
                'label' => 'Boîte',
                'choices' => [
                  'Aucune' => false,
                  'Incluse' => true
                ]
              ])
            ->add('noticeProduit', ChoiceType::class, [
                'label' => 'Notice',
                'choices' => [
                  'Aucune' => false,
                  'Incluse' => true
                ]
              ])
            ->add('prixProduit', IntegerType::class, [
                'required' => true,
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
                'constraints' => [ // contraintes d'envoie du fichier
                    new Image ([
                        'maxSize' => '1M', // taille (1Mo)
                        'maxSizeMessage' => 'Le fichier est trop volumineux ({{ size }} Mo). Taille maximum : 1 Mo',
                        'mimeTypes' => [ // type d'image tolérer
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
            // Importation des différentes Classes/Entités lié à la table Produit [à trouver]
            ->add('genreProduit', EntityType::class, [
                'class' => GenreProduit::class,
                'choice_label' => 'nom_genre',
                // Nom de la valeur dans la BDD car genre est une entité de la BDD
                'multiple' => true, // Précision de la liste d'un ou plusieurs genre(s)
                'expanded' => true
            ])
            ->add('langueProduit', EntityType::class, [
                'class' => LangueProduit::class,
                'choice_label' => 'nom_langue',
                'multiple' => true
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
    /*
    Dans produit/index.html.twig pour afficher les autres données
    <td class="align-middle">{{ produits.genreProduit.nomGenre }}</td> // Genre
    <td class="align-middle">{{ produits.langueProduit.nomCategorie }}</td> // Langue

    {% for langues in langue %}<!-- Pour toutes les langues présente dans la table Langue_Produit -->
    {% if langues.fkProduit.id == produits.id %} <!-- Si la langueest = à l'ID du produit-->
      <td class="align-middle"> {{ langues.nomLangue }} </td> <!-- Affiche le nom de la langue-->
    {% endif %}
    {% endfor %}
    */
}
