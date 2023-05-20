<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'required' => true,
                'attr' => [
                    'placeholder' => 'prénom',
                    'class' => 'attribute'
                ],

                'row_attr' => [
                    'class' => 'form-floating',
                ],

            ])

            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Nom'
                ],

                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])

            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => true,
                'attr' => [
                    'placeholder' => 'email'
                ],

                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])

            ->add('telephone', TextType::class, [
                'label' => 'Téléphone',
                'required' => true,
                'attr' => [
                    'placeholder' => 'téléphone'
                ],

                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])

            ->add('comment', EntityType::class, [
                'label' => 'Choisir votre gendre',
                'class' => Comment::class,
                'choice_label' => 'label',
                'multiple' => false,
                'expanded' => true,
                'attr' => [
                    'class' => 'attribute'
                ]
            ])
            

            ->add('terms', CheckboxType::class, [
                'label' => "Merci d'accepter les conditions du site",
                'required' => true,
               
            ])

            ->add('content', TextareaType::class, [
                'label' => 'Message',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Votre Message......'
                ],

                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
           

            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);

       
    }

    public function videcontact()
    {
        return '';
    }
}
