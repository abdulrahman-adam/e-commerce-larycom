<?php

namespace App\Form;

use App\Entity\Delivery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommanderFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullname', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Nom et Prénom',
                    'required' => true
                ]
            ])

            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Example larycom@commerce.fr',
                    'required' => true
                ]
            ])

            ->add('number', NumberType::class, [
                'label' => 'Téléphone',
                'attr' => [
                    'placeholder' => 'Example 0123456789',
                    'required' => true
                ]
            ])

            ->add('address', TextType::class, [
                'label' => 'Adresse complet',
                'attr' => [
                    'placeholder' => 'Example 1 rue de la paix 75000 PARIS',
                    'required' => true
                ]
            ])

            ->add('picture', FileType::class, [
                'label' => "Factures d'achats",
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control', 
                ]
            ])
            
            ->add('delivery', EntityType::class, [
                'label' => 'temps de la livraison',
                'class' => Delivery::class,
                'choice_label' => 'time',
                'multiple' => false,
                'expanded' => true,
                'attr' => [
                    'class' => 'attribute'
                ]
            ])
            
            ->add('description', TextareaType::class, [
                'label' => 'Description du Produit',
                'attr' => [
                    'placeholder' => "Example j'ai recommndé l'ordinateur ASUS noir ça prix 555.9 € ...etc",
                    'required' => true
                ]
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Recommander',
                
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
