<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AccessoiresFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'label' => "Nom l'accessoire",
            'required' => true,
            'attr' => [
                'class' => 'form-control',
                'placeholder' => "Nom l'accessoire",
            ]
        ])


        ->add('category', TextType::class, [
            'label' => "Catégorie de l'accessoire",
            'required' => true,
            'attr' => [
                'class' => 'form-control',
                'placeholder' => "catégorie de l'accessoire",
            ]
        ])

        ->add('price', NumberType::class, [
            'label' => "Prix de l'accessoire",
            'required' => true,
            'attr' => [
                'class' => 'form-control',
                'placeholder' => "Prix de l'accessoire",
            ]
        ])

        ->add('picture', FileType::class, [
            'label' => "Image de l'accessoire",
            'mapped' => false,
            'required' => false,
        ])

    

        ->add('submit', SubmitType::class, [
            'label' => "Ajouter",
        
        ])
    ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
