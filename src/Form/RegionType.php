<?php

namespace App\Form;
// Entités/Classes
use App\Entity\RegionProduit;
// Fonctions
use Symfony\Component\Form\Extension\Core\Type\TextType;
// Fonctionnement
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
      $builder
      ->add('nomRegion', TextType::class, [
          'required' => true,
          'label' => 'Nom de la région',
          'attr' => [
               'maxLenght' => 25,
               'placeholder' => 'Europe (PAL)'
          ]
        ])
      ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RegionProduit::class,
        ]);
    }
}
