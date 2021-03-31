<?php

namespace App\Form\DamageCase\GeneralDamage;

use App\Entity\DamageCase\GeneralDamage\GeneralDamage;
use App\Entity\DamageCase\GeneralDamage\GeneralDamageTyp;
use App\Form\DamageCase\Part\DamageCauseType;
use App\Form\DamageCase\Part\DamageEventType;
use App\Form\DamageCase\Part\InsurerType;
use App\Form\DamageCase\Part\PaymentType;
use App\Form\DamageCase\Part\PoliceRecordingType;
use App\Form\DamageCase\Part\PolicyholderType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GeneralDamageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typs', EntityType::class, [
                'label' => false,
                'class' => GeneralDamageTyp::class,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true,
                'attr' => [
                    'class' => 'line four-per-line wrap-checkboxes'
                ],
                'required' => false,
                'placeholder' => false
            ])
            ->add('insurer',InsurerType::class,[
                'label' => false
            ])
            ->add('policyholder',PolicyholderType::class,[
                'label' => 'Versicherungsnehmer',
                'required' => true
            ])
            ->add('damageEvent',DamageEventType::class,[
                'label' => 'Schadenereignis',
                'required' => false
            ])
            ->add('traceOfBreakIn',TraceOfBreakInType::class,[
                'label' => 'Einbruch (nur bei Einbruch-Diebstahl)',
                'required' => false
            ])
            ->add('itemsOtherInsurance',ItemsOtherInsuranceType::class,[
                'label' => 'Anderweitig Versichert',
                'required' => false
            ])
            ->add('repairCompany',RepairCompanyType::class,[
                'label' => 'Reparatur Firma',
                'required' => false
            ])
            ->add('policeRecording', PoliceRecordingType::class, [
                'label' => 'polizeiliche Aufnahme',
                'hasDamageCause' => false
            ])
            ->add('payment',PaymentType::class, [
                'label' => 'Zahlungen'
            ])
            ->add('damageCause',DamageCauseType::class,[
                'label' => 'Schadenverursacher',
                'required' => false
            ])
            ->add('buildingDamage',BuildingDamageType::class,[
                'label' => 'Bei Gebäudeschäden',
                'required' => false
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
            'data_class' => GeneralDamage::class,
        ]);
    }
}
