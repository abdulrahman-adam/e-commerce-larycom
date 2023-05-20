<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BagagesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'label' => "Nom du bagage",
            'required' => true,
            'attr' => [
                'class' => 'form-control',
                'placeholder' => "Entrez nom du bagage",
            ]
        ])

        ->add('category', TextType::class, [
            'label' => "Cateégorie du bagage",
            'required' => true,
            'attr' => [
                'class' => 'form-control',
                'placeholder' => "Entrez cateégorie du bagage",
            ]
        ])

        ->add('price', NumberType::class, [
            'label' => "Prix du bagage",
            'required' => true,
            'attr' => [
                'class' => 'form-control',
                'placeholder' => "Entrez prix du bagage",
            ]
        ])

        ->add('picture', FileType::class, [
            'label' => "Image du bagage",
            'mapped' => false,
            'required' => false,
        ])

      

        ->add('submit', SubmitType::class, [
            'label' => "Ajouter",
        
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
