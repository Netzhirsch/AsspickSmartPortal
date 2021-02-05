<?php

namespace App\Form\DamageCase\Part;

use App\Entity\DamageCase\Part\PersonalInjury;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonalInjuryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('personFirstname',TextType::class,[
                'label' => 'Vorname',
                'required' => false
            ])
            ->add('personLastname',TextType::class,[
                'label' => 'Nachname',
                'required' => false
            ])
            ->add('injuries',TextType::class,[
                'label' => 'Welche Verletzungen',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PersonalInjury::class,
        ]);
    }
}
