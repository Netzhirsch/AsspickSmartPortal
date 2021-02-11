<?php

namespace App\Form\DamageCase\Car;

use App\Entity\DamageCase\Car\OpponentCar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OpponentCarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('licensePlate',TextType::class,[
                'label' => 'Amtl. Kennzeichen',
                'required' => false
            ])
            ->add('manufacturer',TextType::class,[
                'label' => 'Hersteller',
                'required' => false
            ])
            ->add('model',TextType::class,[
                'label' => 'Modell',
                'required' => false
            ])
            ->add('yearOfManufacture',TextType::class,[
                'label' => 'Baujahr',
                'required' => false
            ])
            ->add('kmStatus',NumberType::class,[
                'label' => 'Km-Stand (Kasko)',
                'required' => false
            ])
            ->add('insuredWith',TextType::class,[
                'label' => 'Versichert bei',
                'required' => false
            ])
            ->add('insuranceNumber',TextType::class,[
                'label' => 'Versicherungsnummer',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OpponentCar::class,
        ]);
    }
}
