<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom l'article",
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Nom l'article",
                ]
            ])

            ->add('price', NumberType::class, [
                'label' => "Prix de l'article",
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Prix de l'article",
                ]
            ])

            ->add('picture', FileType::class, [
                'label' => "Image de l'article",
                'mapped' => false,
                'required' => false,
            ])

            ->add('content', TextareaType::class, [
                'label' => "Description de l'article",
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Description de l'article",
                ]
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
