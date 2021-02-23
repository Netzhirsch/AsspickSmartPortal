<?php

namespace App\Form;

use App\Entity\Fibu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FibuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code',TextType::class,[
                'label' => 'Kürzel'
            ])
            ->add('intermediaryName',TextType::class,[
                'label' => 'Vermittlernummer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Fibu::class,
        ]);
    }
}
