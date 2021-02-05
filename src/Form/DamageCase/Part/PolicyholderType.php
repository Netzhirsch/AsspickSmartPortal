<?php

namespace App\Form\DamageCase\Part;

use App\Entity\DamageCase\Part\Policyholder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PolicyholderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname',TextType::class,[
                'label' => 'Vorname',
            ])
            ->add('lastname',TextType::class,[
                'label' => 'Nachname',
            ])
            ->add('streetMailbox',TextType::class,[
                'label' => 'Straße/Postfach',
            ])
            ->add('postCode',TextType::class,[
                'label' => 'PLZ',
            ])
            ->add('location',TextType::class,[
                'label' => 'Ort',
            ])
            ->add('phone',TextType::class,[
                'label' => 'Telefon',
            ])
            ->add('email',EmailType::class,[
                'label' => 'E-Mail Adresse',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Policyholder::class,
        ]);
    }
}
