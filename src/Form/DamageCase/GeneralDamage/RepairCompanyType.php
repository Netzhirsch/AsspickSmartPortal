<?php

namespace App\Form\DamageCase\GeneralDamage;

use App\Entity\DamageCase\GeneralDamage\RepairCompany;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RepairCompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'label' => 'Firmenname',
                'required' => false
            ])
            ->add('streetMailbox',TextType::class,[
                'label' => 'Straße / Postfach',
                'required' => false
            ])
            ->add('postCode',TextType::class,[
                'label' => 'PLZ',
                'required' => false
            ])
            ->add('location',TextType::class,[
                'label' => 'Ort',
                'required' => false
            ])
            ->add('email',EmailType::class,[
                'label' => 'E-Mail Adresse',
                'required' => false
            ])
            ->add('phone',TextType::class,[
                'label' => 'Telefon',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RepairCompany::class,
        ]);
    }
}
