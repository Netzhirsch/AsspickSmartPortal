<?php

namespace App\Form\DamageCase\GeneralDamage;

use App\Entity\DamageCase\GeneralDamage\TraceOfBreakIn;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TraceOfBreakInType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isTracePresent', ChoiceType::class, [
                'label' => 'Einbruchspuren vorhanden?',
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
            ->add('description',TextareaType::class,[
                'label' => 'Welcher Art',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TraceOfBreakIn::class,
        ]);
    }
}
