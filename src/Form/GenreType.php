<?php

namespace App\Form;
// Entités/Classes
use App\Entity\GenreProduit;
// Fonctions
use Symfony\Component\Form\Extension\Core\Type\TextType;
// Fonctionnement
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GenreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nomGenre', TextType::class, [
            'required' => true,
            'label' => 'Nom du genre',
            'attr' => [
                 'maxLenght' => 25
            ]
          ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GenreProduit::class,
        ]);
    }
}
