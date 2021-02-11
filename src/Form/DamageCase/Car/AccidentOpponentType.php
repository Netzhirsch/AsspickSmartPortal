<?php

namespace App\Form\DamageCase\Car;

use App\Entity\DamageCase\Car\AccidentOpponent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccidentOpponentType extends AbstractType
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AccidentOpponent::class,
        ]);
    }
}
