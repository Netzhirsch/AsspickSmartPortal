<?php

namespace App\Form\DamageCase\Part;

use App\Entity\DamageCase\Part\PoliceRecording;
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
                    'class' => 'line four-per-line wrap-checkboxes'
                ],
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PoliceRecording::class,
        ]);
    }
}
