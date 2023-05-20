<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class AddressFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Quel nom souhaitez-vous donner à votre adresse',
                'attr' => [
                    'placeholder' => "Entrez votre nom",
                ]
            ])

            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => "Entrez votre prénom",
                ]
            ])

            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => "Enter votre nom",
                ]
            ])

            ->add('company', TextType::class, [
                'label' => 'Votre société',
                'attr' => [
                    'placeholder' => "(facultatif) Entrer le nom de votre société",
                ]
            ])


            ->add('address', TextType::class, [
                'label' => 'Votre adresse',
                'attr' => [
                    'placeholder' => "1 rue de la paix ...",
                ]
            ])

            ->add('postal', TextType::class, [
                'label' => 'Votre code postal',
                'attr' => [
                    'placeholder' => "Entrez votre code postal",
                ]
            ])

            ->add('city', TextType::class, [
                'label' => 'Votre ville',
                'attr' => [
                    'placeholder' => "Entrez votre ville",
                ]
            ])

            ->add('country', CountryType::class, [
                'label' => 'pays',
                
            ])


            ->add('phone', TelType::class, [
                'label' => 'Téléphone',
                'attr' => [
                    'placeholder' => "Votre téléphone",
                ]
            ])

            ->add('submit', SubmitType::class, [
               'label' => 'Valider',
               'attr' => [
                'class' => 'btn-block btn-info'
               ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}