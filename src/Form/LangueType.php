<?php

namespace App\Form;
// Entités/Classes
use App\Entity\LangueProduit;
// Fonctions
use Symfony\Component\Form\Extension\Core\Type\TextType;
// Fonctionnement
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LangueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nomLangue', TextType::class, [
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
            'data_class' => LangueProduit::class,
        ]);
    }
}
