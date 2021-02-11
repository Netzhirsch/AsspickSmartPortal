<?php

namespace App\Form\DamageCase;

use App\Entity\DamageCase\Liability;
use App\Entity\DamageCase\TypeOfOwnership;
use App\Form\DamageCase\Part\ClaimantType;
use App\Form\DamageCase\Part\DamageCauseType;
use App\Form\DamageCase\Part\DamageEventType;
use App\Form\DamageCase\Part\InsuredType;
use App\Form\DamageCase\Part\PaymentType;
use App\Form\DamageCase\Part\PersonalInjuryType;
use App\Form\DamageCase\Part\PoliceRecordingType;
use App\Form\DamageCase\Part\PolicyholderType;
use App\Form\DamageCase\Part\WitnessType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LiabilityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('insured',InsuredType::class,[
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
            ->add('damageCause',DamageCauseType::class,[
                'label' => 'Schadenverursacher',
                'required' => false
            ])
            ->add('witness',WitnessType::class,[
                'label' => 'Zeuge',
                'required' => false
            ])
            ->add('isRepairPossible', ChoiceType::class, [
                'label' => 'Reparatur möglich?',
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
            ->add('typeOfOwnership', EntityType::class, [
                'label' => 'Hatten Sie die beschädigte Sache',
                'class' => TypeOfOwnership::class,
                'choice_label' => 'name',
                'required' => false
            ])
            ->add('policeRecording', PoliceRecordingType::class, [
                'label' => 'polizeiliche Aufnahme',
                'required' => false
            ])
            ->add('claimant',ClaimantType::class,[
                'label' => 'Anspruchsteller',
                'required' => false
            ])
            ->add('personalInjury',PersonalInjuryType::class,[
                'label' => 'Personenschäden',
                'required' => false
            ])
            ->add('payment',PaymentType::class, [
                'label' => 'Zahlungen',
                'required' => false
            ])
            ->add('file', FileType::class, [
                'label' => 'Fotos',
                'mapped' => false,
                'multiple' => true,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Liability::class,
        ]);
    }
}