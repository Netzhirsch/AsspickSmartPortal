<?php

namespace App\Form\DamageCase\Part;

use App\Entity\DamageCase\Part\Damage\CauseOfDamageTyp;
use App\Entity\DamageCase\Part\Damage\DamageCausedBy;
use App\Entity\DamageCase\Part\Damage\DamageEvent;
use App\Entity\DamageCase\Part\Damage\DamageTyp;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('locationTwo',TextType::class,[
                'label' => 'zweiter Ort',
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
                ],
                'required' => false
            ])
            ->add('damageAmountOnOpponent', NumberType::class, [
                'label' => 'Geschätzte Schadenhöhe am gegnerischen Fahrzeug in EUR',
                'scale' => 2,
                'html5' => true,
                'attr' => [
                    'min' => '0.00',
                    'step' => '0.01',
                ],
                'required' => false
            ])
            ->add('causedBy', EntityType::class, [
                'label' => 'Verursacht durch',
                'class' => DamageCausedBy::class,
                'choice_label' => 'name',
                'required' => false
            ])
            ->add('typs', EntityType::class, [
                'label' => 'Schadenart',
                'class'  => DamageTyp::class,
                'choice_label' => 'name',
                'multiple'  => true,
                'expanded' => true,
                'required' => false,
                'attr' => [
                    'class' => 'line four-per-line wrap-checkboxes'
                ]
            ])
            ->add('causeOfDamageTyps', EntityType::class, [
                'label' => 'Schadenursache (nur bei Leitungswasser)',
                'class'  => CauseOfDamageTyp::class,
                'choice_label' => 'name',
                'multiple'  => true,
                'expanded' => true,
                'required' => false,
                'attr' => [
                    'class' => 'line four-per-line wrap-checkboxes'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DamageEvent::class
        ]);
    }
}
