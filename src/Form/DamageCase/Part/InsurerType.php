<?php

namespace App\Form\DamageCase\Part;

use App\Entity\DamageCase\Part\Insurer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InsurerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'label' => 'Versicherer',
				'required' => true
            ])
            ->add('insuranceNumber',TextType::class,[
                'label' => 'Versicherungsschein-Nr.',
				'required' => true
            ])
            ->add('dangerNumber',TextType::class,[
                'label' => 'Schaden-Nummer',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Insurer::class,
        ]);
    }
}
