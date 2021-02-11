<?php

namespace App\Form\DamageCase\Part;

use App\Entity\DamageCase\Part\CriminalProceedingsAgainstTyp;
use App\Entity\DamageCase\Part\PoliceRecording;
use App\Entity\DamageCase\Part\WhoIsWarnedWithCharge;
use App\Enumeration\CriminalProceedingsAgainstTypEnum;
use App\Repository\DamageCase\Part\CriminalProceedingsAgainstTypRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PoliceRecordingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isRecorded',ChoiceType::class,[
                'label' => 'aufgenommen',
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
            ->add('department',TextType::class,[
                'label' => 'Dienststelle',
                'required' => false
            ])
            ->add('fileReference',TextType::class,[
                'label' => 'Aktenzeichen',
                'required' => false
            ])
            ->add('diaryNumber',TextType::class,[
                'label' => 'Tagebuch Nummer',
                'required' => false
            ])
            ->add('criminalProceedingsAgainst', EntityType::class, [
                'label' => 'gegen wenn',
                'class' => CriminalProceedingsAgainstTyp::class,
                'choice_label' => 'name',
                'multiple'  => true,
                'expanded' => true,
                'required' => false,
                'attr' => [
                    'class' => 'line two-per-line wrap-checkboxes'
                ],
                'query_builder' => function(CriminalProceedingsAgainstTypRepository $repository) use ($options){
                    $qb =  $repository->createQueryBuilder('c');
                    if ($options['hasDamageCause']) {
                        $exclude = CriminalProceedingsAgainstTypEnum::UNFALLGEGNER;
                    } else {
                        $exclude = CriminalProceedingsAgainstTypEnum::SCHADENVERURSACHER;
                    }
                    return $qb->where('c.id <> :unfallgegner')
                        ->setParameter(
                            'unfallgegner', $exclude)
                    ;
                }
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
                    'class' => 'line two-per-line wrap-checkboxes'
                ],
                'required' => false,
                'placeholder' => false
            ])
            ->add('isWarnedWithCharge', ChoiceType::class, [
                'label' => 'Wurden jemand gebührenpflichtig verwarnt?',
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
            ->add('whoIsWarnedWithCharge', EntityType::class, [
                'label' => 'wer',
                'class' => WhoIsWarnedWithCharge::class,
                'choice_label' => 'name',
                'multiple'  => true,
                'expanded' => true,
                'required' => false,
                'attr' => [
                    'class' => 'line two-per-line wrap-checkboxes'
                ],
            ])
            ->add('hasDrugUse', ChoiceType::class, [
                'label' => 'Alkohol-/Drogengenuss',
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
            ->add('hasDrugTest', ChoiceType::class, [
                'label' => 'Alkohol-/Drogentest',
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
            ->add('drugTestResult',TextType::class,[
                'label' => 'Ergebnis in  ‰',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PoliceRecording::class,
            'hasDamageCause' => true
        ]);
    }
}
