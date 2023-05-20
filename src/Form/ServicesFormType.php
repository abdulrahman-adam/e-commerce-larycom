<?php

namespace App\Form;

use App\Entity\Partiel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ServicesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom et Prénom',
                'attr' => [
                    'placeholder' => 'Nom et Prénom',
                ],
                
                'required' => true,

                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])

            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Email',
                ],
                'required' => true,

                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])

            ->add('number', NumberType::class, [
                'label' => 'Téléphone',
                'attr' => [
                    'placeholder' => 'Téléphone',
                ],
                'required' => true,

                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])

            ->add('terms', CheckboxType::class, [
                'label' => "Merci d'accepter les conditions du site",
                'attr' => [
                    'placeholder' => 'Téléphone',
                ],
                'required' => true,

                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])

            // ->add('partiel', ChoiceType::class, [
                // 'label' => 'Accepter les term',
                // 'class' => Partiel::class,
                // 'choice_label' => 'term',
                // 'expanded' => true,
                // 'multiple' => true,
            // ])

            ->add('description', TextareaType::class, [
                'label' => 'Votre Message',
                'attr' => [
                    'placeholder' => 'Envoyer-nous votre message',
                ],
                'required' => true,

                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])

           ->add('submit', SubmitType::class, [
            'label' => 'Envoyer',
            'attr' => [
                'class' => 'btnAnnuler',
            ],
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
