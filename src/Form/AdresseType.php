<?php

namespace App\Form;

use App\Entity\Adresse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class AdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, [
                'label' => 'Libellé',
                'constraints' => [
                    new Length([
                        'min' => 4,
                        'max' => 25
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Domicile, travail, livraison, facturation, etc...'
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
                    'placeholder' => 'Votre nom'
                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'constraints' => [
                    new Length([
                        'min' => 4,
                        'max' => 25
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Votre prénom'
                ]
            ])
            ->add('societe', TextType::class, [
                'label' => 'Société',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Nom de la société et Num Siret'
                ]
            ])
            ->add('numero', TextType::class, [
                'label' => 'Numéro',
                'attr' => [
                    'placeholder' => 'numéro'
                ]
            ])
            ->add('rue', TextType::class, [
                'label' => 'Rue',
                'attr' => [
                    'placeholder' => 'rue'
                ]
            ])
            ->add('complement', TextType::class, [
                'label' => 'Complément d\'addresse',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Appt, résidence, etc...'
                ]
            ])
            ->add('codePostal', TextType::class, [
                'label' => 'Code Postal',
                'attr' => [
                    'placeholder' => 'code postal'
                ]
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'placeholder' => 'ville'
                ]
            ])
            ->add('pays', CountryType::class, [
                'label' => 'Pays',
                'attr' => [
                    'placeholder' => 'pays'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'enrgistrer l\'adresse',
                'attr' => [
                    'class' => 'btn btn-success btn-block'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adresse::class,
        ]);
    }
}
