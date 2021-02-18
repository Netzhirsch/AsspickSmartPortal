<?php

namespace App\Form\DamageCase\GeneralDamage;

use App\Entity\DamageCase\GeneralDamage\ItemsOtherInsurance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemsOtherInsuranceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('hasOtherInsurance', ChoiceType::class, [
                'label' => false,
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
            ->add('insured',TextType::class,[
                'label' => 'Versicherer',
                'required' => false
            ])
            ->add('insuranceNumber',TextType::class,[
                'label' => 'Vers.-Schein-Nr.',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ItemsOtherInsurance::class,
        ]);
    }
}
