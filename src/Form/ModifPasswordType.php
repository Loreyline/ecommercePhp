<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'disabled' => true
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'disabled' => true
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse électronique',
                'disabled' => true
            ])
            ->add('oldPassword', PasswordType::class, [
                'label' => 'Mot de passe actuel',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Mot de passe actuel'
                ]
            ])
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'label' => 'Nouveau Mot de passe',
                'invalid_message' => 'les 2 mots de passe doivent être identiques',
                'required' => true,
                'first_options' => [
                    'label' => 'Nouveau Mot de passe',
                    'attr' => [
                        'placeholder' => 'minimum 8 caractères'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmation du Nouveau Mot de passe',
                    'attr' => [
                        'placeholder' => 'doit être identique au mot de passe'
                    ]
                ]

            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Modifier'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
