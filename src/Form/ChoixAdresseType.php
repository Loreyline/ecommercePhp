<?php

namespace App\Form;

use App\Entity\Adresse;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChoixAdresseType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['user'];
        $builder
            ->add('adressesLivraison', EntityType::class, [
                'label' => 'Choisir l\'adresse de livraison',
                'required' => true,
                'class' => Adresse::class,
                'choices' => $user->getAdresses(),
                'multiple' => false,
                'expanded' => true
            ])
            ->add('adressesFacturation', EntityType::class, [
                'label' => 'Choisir l\'adresse de facturation',
                'required' => true,
                'class' => Adresse::class,
                'choices' => $user->getAdresses(),
                'multiple' => false,
                'expanded' => true
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider les adresses',
                'attr' => [
                    'class' => 'btn btn-block btn-success'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'user' => array()
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
