<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du produit',
                'required' => true
            ])

            ->add('type', TextType::class, [
                'label' => 'La catégorei du produit',
                'required' => true
            ])

            ->add('original', TextType::class, [
                'label' => "L'original du produit",
                'required' => true
            ])

            ->add('price', NumberType::class, [
                'label' => "Le prix du produit",
                'required' => true
            ])

            ->add('picture', FileType::class, [
                'label' => "Image du produit",
                'mapped' => false,
                'required' => false,
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Modifier',
                'attr' => [
                    '
                class' => 'btn btn-primary'
                ]
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
