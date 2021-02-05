<?php

namespace App\Form\DamageCase;

use App\Entity\DamageCase\Liability;
use App\Entity\DamageCase\Part\CriminalProceedingsAgainstTyp;
use App\Entity\DamageCase\TypeOfOwnership;
use App\Form\DamageCase\Part\ClaimantType;
use App\Form\DamageCase\Part\DamageCauseType;
use App\Form\DamageCase\Part\DamageEventType;
use App\Form\DamageCase\Part\InsuredType;
use App\Form\DamageCase\Part\PaymentType;
use App\Form\DamageCase\Part\PersonalInjuryType;
use App\Form\DamageCase\Part\PoliceRecordingType;
use App\Form\DamageCase\Part\PolicyholderType;
use App\Form\DamageCase\Part\SignatureType;
use App\Form\DamageCase\Part\WitnessType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LiabilityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('insured',InsuredType::class,[
                'label' => false
            ])
            ->add('policyholder',PolicyholderType::class,[
                'label' => 'Versicherungsnehmer'
            ])
            ->add('damageEvent',DamageEventType::class,[
                'label' => 'Schadenereignis'
            ])
            ->add('damageCause',DamageCauseType::class,[
                'label' => 'Schadenverursacher'
            ])
            ->add('witness',WitnessType::class,[
                'label' => 'Zeuge'
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
                    'class' => 'line four-per-line wrap-checkboxes'
                ],
            ])
            ->add('typeOfOwnership', EntityType::class, [
                'label' => 'Hatten Sie die beschädigte Sache',
                'class' => TypeOfOwnership::class,
                'choice_label' => 'name',
                'required' => false
            ])
            ->add('policeRecording', PoliceRecordingType::class, [
                'label' => 'polizeiliche Aufnahme'
            ])
            ->add('criminalProceedingsAgainst', EntityType::class, [
                'label' => 'gegen wenn',
                'class' => CriminalProceedingsAgainstTyp::class,
                'choice_label' => 'name',
                'required' => false
            ])
            ->add('hasCriminalProceedings', ChoiceType::class, [
                'label' => 'Wurde ein Strafverfahren eingeleitet?',
                'choices' => [
                    'Ja' => true,
                    'Nein' => false
                ],
                'multiple' => false,
                'expanded' => true,
                'attr' => [
                    'class' => 'line four-per-line wrap-checkboxes'
                ],
            ])
            ->add('claimant',ClaimantType::class,[
                'label' => 'Anspruchsteller'
            ])
            ->add('personalInjury',PersonalInjuryType::class,[
                'label' => 'Personenschäden'
            ])
            ->add('payment',PaymentType::class, [
                'label' => 'Zahlungen'
            ])
            ->add('signature', SignatureType::class, [
                'label' => false
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
