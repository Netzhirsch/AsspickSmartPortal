<?php

namespace App\Form\DamageCase\Part;

use App\Entity\DamageCase\Part\Signature;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignatureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('location',TextType::class,[
                'label' => 'Ort',
            ])
            ->add('date',DateType::class,[
                'label' => 'Datum',
                'html5' => true,
                'widget' => 'single_text'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Signature::class,
        ]);
    }
}
