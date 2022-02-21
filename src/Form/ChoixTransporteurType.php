<?php

namespace App\Form;

use App\Entity\Transporteur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChoixTransporteurType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['user'];
        $builder
            ->add('transporteurs', EntityType::class, [
                'label' => 'Choisir le transporteur',
                'required' => true,
                'class' => Transporteur::class,
                'multiple' => false,
                'expanded' => true
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Aperçu de la commande',
                'attr' => [
                    'class' => 'btn btn-block btn-success'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['user' => array()]);
    }
}
