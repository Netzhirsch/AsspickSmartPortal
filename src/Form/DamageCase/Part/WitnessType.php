<?php

namespace App\Form\DamageCase\Part;

use App\Entity\DamageCase\Part\Witness;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WitnessType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname',TextType::class,[
                'label' => 'Vorname',
                'required' => false
            ])
            ->add('lastname',TextType::class,[
                'label' => 'Nachname',
                'required' => false
            ])
            ->add('streetMailbox',TextType::class,[
                'label' => 'Straße/Postfach',
                'required' => false
            ])
            ->add('postCode',TextType::class,[
                'label' => 'PLZ',
                'required' => false
            ])
            ->add('location',TextType::class,[
                'label' => 'Ort',
                'required' => false
            ])
            ->add('phone',TextType::class,[
                'label' => 'Telefon',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Witness::class,
        ]);
    }
}
