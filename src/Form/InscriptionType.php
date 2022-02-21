<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'constraints' => [
                    new Length([
                        'min' => 4,
                        'max' => 25
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Saisir votre prénom'
                ]
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'constraints' => [
                    new Length([
                        'min' => 4,
                        'max' => 25
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Saisir votre nom'
                ]
            ])
            ->add('dateNaissance', DateType::class, [
                'label' => 'Date de naissance',
                'format' => 'dd-MM-yyyy',
                'years' => range(1900, 2050)
            ])
            ->add('telephone', TelType::class, [
                'label' => 'Téléphone',
                'attr' => [
                    'placeholder' => 'Votre numéro de téléphone'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse électronique',
                'attr' => [
                    'placeholder' => 'Adresse email valide'
                ]
            ])
            // ->add('password', PasswordType::class, [
            //     'label' => 'Mot de passe',
            //     'attr' => [
            //         'placeholder' => 'minimum 8 caractères'
            //     ]
            // ])
            // ->add('password_confirm', PasswordType::class, [
            //     'label' => 'Confirmer Mot de passe',
            //     'mapped' => false,
            //     'attr' => [
            //         'placeholder' => 'Confirmer le mot de passe'
            //     ]
            // ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'label' => 'Mot de passe',
                'invalid_message' => 'les 2 mots de passe doivent être identiques',
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'placeholder' => 'minimum 8 caractères'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmation du Mot de passe',
                    'attr' => [
                        'placeholder' => 'doit être identique au mot de passe'
                    ]
                ]

            ])
            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
