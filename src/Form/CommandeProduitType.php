<?php

namespace App\Form;

use App\Entity\CommandeProduit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity')
            ->add('frais_port')
            ->add('assurance')
            ->add('tva')
            ->add('prix')
            ->add('article')
            ->add('commande')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CommandeProduit::class,
        ]);
    }
}
