<?php

namespace App\Form\DamageCase\Car;

use App\Entity\DamageCase\Car\Car;
use App\Entity\DamageCase\Car\TheftProtectionTyp;
use App\Entity\DamageCase\Car\TypOfInsurance;
use App\Entity\DamageCase\Car\TypOfTrip;
use App\Entity\DamageCase\Car\WhoseCar;
use App\Form\DamageCase\Part\DamageEventType;
use App\Form\DamageCase\Part\InsurerType;
use App\Form\DamageCase\Part\PaymentType;
use App\Form\DamageCase\Part\PoliceRecordingType;
use App\Form\DamageCase\Part\PolicyholderType;
use App\Form\DamageCase\Part\WitnessType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typOfInsurance', EntityType::class, [
                'label' => false,
                'class' => TypOfInsurance::class,
                'choice_label' => 'name',
                'expanded' => true,
                'attr' => [
                    'class' => 'line two-per-line wrap-checkboxes'
                ],
                'required' => false,
                'placeholder' => false
            ])
            ->add('typOfTrip', EntityType::class, [
                'label' => false,
                'class' => TypOfTrip::class,
                'choice_label' => 'name',
                'expanded' => true,
                'attr' => [
                    'class' => 'line two-per-line wrap-checkboxes'
                ],
                'required' => false,
                'placeholder' => false
            ])
            ->add('licensePlate', TextType::class, [
                'label' => 'Amtliches Kennzeichen:',
                'required' => false
            ])
            ->add('insurer',InsurerType::class,[
                'label' => false,
                'required' => false
            ])
            ->add('policyholder',PolicyholderType::class,[
                'label' => 'Versicherungsnehmer',
                'required' => false
            ])
            ->add('damageEvent',DamageEventType::class,[
                'label' => 'Schadenereignis',
                'required' => false
            ])
            ->add('driver',DriverType::class,[
                'label' => 'Fahrer(in) zum Schadenzeitpunkt',
                'required' => false
            ])
            ->add('hasOwnClaims', ChoiceType::class, [
                'label' => 'Haben Sie selbst Ansprüche gestellt?',
                'choices' => [
                    'Ja' => true,
                    'Nein' => false
                ],
                'multiple' => false,
                'expanded' => true,
                'attr' => [
                    'class' => 'line two-per-line wrap-checkboxes'
                ],
                'required' => false,
                'placeholder' => false
            ])
            ->add('accidentOpponent',AccidentOpponentType::class,[
                'label' => 'Unfallgegner',
                'required' => false
            ])
            ->add('opponentCar',OpponentCarType::class,[
                'label' => 'Fahrzeug',
                'required' => false
            ])
            ->add('typeOfInjury', TextType::class, [
                'label' => 'Art der Verletzung',
                'required' => false
            ])
            ->add('theftProtectionTyp', EntityType::class, [
                'label' => 'Bei Diebstahlschäden',
                'class'  => TheftProtectionTyp::class,
                'choice_label' => 'name',
                'multiple'  => true,
                'expanded' => true,
                'required' => false,
                'attr' => [
                    'class' => 'line four-per-line wrap-checkboxes'
                ]
            ])
            ->add('viewedOn',TextareaType::class,[
                'label' => 'Wo kann das Fahrzeug besichtigt werden? Adresse mit Ansprechpartner/Telefon',
                'required' => false
            ])
            ->add('whoseCars', EntityType::class, [
                'label' => 'Wessen Fahrzeug?',
                'class'  => WhoseCar::class,
                'choice_label' => 'name',
                'multiple'  => true,
                'expanded' => true,
                'required' => false,
                'attr' => [
                    'class' => 'line four-per-line wrap-checkboxes'
                ]
            ])
            ->add('policeRecording', PoliceRecordingType::class, [
                'label' => 'polizeiliche Aufnahme',
                'hasDamageCause' => false
            ])
            ->add('witness',WitnessType::class,[
                'label' => 'Zeuge'
            ])
            ->add('witnessTwo',WitnessType::class,[
                'label' => 'Zeugen',
                'required' => false,
            ])
            ->add('other',TextareaType::class,[
                'label' => 'Sonstiges',
                'required' => false
            ])
            ->add('payment',PaymentType::class, [
                'label' => 'Zahlungen'
            ])
            ->add('files', FileType::class, [
                'label' => 'Bilder',
                'mapped' => false,
                'multiple' => true,
                'required' => false,
            ])
            ->add('tmpFolder', HiddenType::class, [
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
