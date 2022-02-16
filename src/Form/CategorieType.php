<?php

namespace App\Form;
// Entités/Classes
use App\Entity\CategorieProduit;
// Fonctions
use Symfony\Component\Form\Extension\Core\Type\TextType;
// Fonctionnement
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
      $builder
      ->add('nomCategorie', TextType::class, [
          'required' => true,
          'label' => 'Nom de la catégorie',
          'attr' => [
               'maxLenght' => 25
          ]
        ])
      ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CategorieProduit::class,
        ]);
    }
}
