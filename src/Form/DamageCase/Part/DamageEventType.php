<?php

namespace App\Form\DamageCase\Part;

use App\Entity\DamageCase\Part\DamageEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class DamageEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date',DateType::class,[
                'html5' => true,
                'widget' => 'single_text',
                'label' => 'Datum'
            ])
            ->add('time',TimeType::class,[
                'html5' => true,
                'widget' => 'single_text',
                'label' => 'Uhrzeit'
            ])
            ->add('location',TextType::class,[
                'label' => 'Ort',
            ])
            ->add('description',TextareaType::class,[
                'label' => 'Schadenschilderung',
            ])
            ->add('itemsDamaged',TextareaType::class,[
                'label' => 'Vom Schaden betroffene Sachen',
                'required' => false
            ])
            ->add('damageAmount', NumberType::class, [
                'label' => 'Geschätzte Schadenhöhe in EUR',
                'scale' => 2,
                'html5' => true,
                'attr' => [
                    'min' => '0.00',
                    'step' => '0.01',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DamageEvent::class,
        ]);
    }
}
