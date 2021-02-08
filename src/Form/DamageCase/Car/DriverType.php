<?php

namespace App\Form\DamageCase\Car;

use App\Entity\DamageCase\Car\Driver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DriverType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname',TextType::class,[
                'label' => 'Vorname',
            ])
            ->add('lastname',TextType::class,[
                'label' => 'Nachname',
            ])
            ->add('streetMailbox',TextType::class,[
                'label' => 'Straße/Postfach',
            ])
            ->add('postCode',TextType::class,[
                'label' => 'PLZ',
            ])
            ->add('location',TextType::class,[
                'label' => 'Ort',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Driver::class,
        ]);
    }
}
