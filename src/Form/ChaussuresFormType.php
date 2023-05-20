<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ChaussuresFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'label' => "Nom de la chausssure",
            'required' => true,
            'attr' => [
                'class' => 'form-control',
                'placeholder' => "Entrez nom la chausssure",
            ]
        ])

        ->add('category', TextType::class, [
            'label' => "Cateégorie la chausssure",
            'required' => true,
            'attr' => [
                'class' => 'form-control',
                'placeholder' => "Entrez cateégorie la chausssure",
            ]
        ])

        ->add('price', NumberType::class, [
            'label' => "Prix la chausssure",
            'required' => true,
            'attr' => [
                'class' => 'form-control',
                'placeholder' => "Entrez prix la chausssure",
            ]
        ])

        ->add('picture', FileType::class, [
            'label' => "Image la chausssure",
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
