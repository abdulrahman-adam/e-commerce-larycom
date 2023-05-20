<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class FiltreFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('searchword', SearchType::class,[
            'label' => 'Nom du Produit',
            'attr' => [
                'placeholder' => 'nom du produit',
                'required' => true,
            ]
        ])

        ->add('minprice', IntegerType::class,[
            'required' => false,
            'label' => 'Prix Min',
            'attr' => [
                'placeholder' => 'prix min 500 €',
                // 'required' => true,
            ]
        ])

        ->add('maxprice', IntegerType::class,[
            'required' => false,
            'label' => 'Prix Max',
            'attr' => [
                'placeholder' => 'prix max 1000 €',
                // 'required' => true,
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
