<?php

namespace App\Form\DamageCase\Part;

use App\Entity\DamageCase\Part\Payment;
use App\Entity\DamageCase\Part\PaymentTransferToTyp;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bank',TextType::class,[
                'label' => 'Bank',
                'required' => false
            ])
            ->add('location',TextType::class,[
                'label' => 'Ort',
                'required' => false
            ])
            ->add('iban',TextType::class,[
                'label' => 'IBAN',
                'required' => false
            ])
            ->add('bic',TextType::class,[
                'label' => 'BIC',
                'required' => false
            ])
            ->add('accountHolder',TextType::class,[
                'label' => 'Kontoinhaber',
                'required' => false
            ])
            ->add('transferTo', EntityType::class, [
                'label' => 'Überweisung',
                'class'  => PaymentTransferToTyp::class,
                'choice_label' => 'name',
                'multiple'  => false,
                'expanded' => true,
                'required' => false,
                'attr' => [
                    'class' => 'line two-per-line wrap-checkboxes'
                ],
                'placeholder' => false
            ])
            ->add('hasInputTaxDeduction', ChoiceType::class, [
                'label' => 'Besteht eine Vorsteuerabzugsberechtigung?',
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Payment::class,
        ]);
    }
}
