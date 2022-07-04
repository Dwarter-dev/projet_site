<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

// Classes Importés
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class, [
              'required' => true,
              'attr' => [
              'maxLenght' => 200,
            ]
        ])
        ->add('subject', TextType::class, [
              'required' => true,
              'attr' => [
              'maxLenght' => 200
            ]
        ])
        ->add('message', TextareaType::class, [
              'required' => true,
              'attr' => [
                'minLenght' => 50,
                'maxLenght' => 1500,
            ]
        ])
        ->add('envoyer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
