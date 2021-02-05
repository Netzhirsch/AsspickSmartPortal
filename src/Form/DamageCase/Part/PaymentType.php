<?php

namespace App\Form\DamageCase\Part;

use App\Entity\DamageCase\Part\Payment;
use Symfony\Component\Form\AbstractType;
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
            ])
            ->add('location',TextType::class,[
                'label' => 'Ort',
            ])
            ->add('iban',TextType::class,[
                'label' => 'IBAN',
            ])
            ->add('bic',TextType::class,[
                'label' => 'BIC',
            ])
            ->add('accountHolder',TextType::class,[
                'label' => 'Kontoinhaber',
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
