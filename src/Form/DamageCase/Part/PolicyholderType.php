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
				'required' => true
            ])
            ->add('lastname',TextType::class,[
                'label' => 'Nachname',
				'required' => true
            ])
            ->add('streetMailbox',TextType::class,[
                'label' => 'Straße/Postfach',
				'required' => true
            ])
            ->add('postCode',TextType::class,[
                'label' => 'PLZ',
				'required' => true
            ])
            ->add('location',TextType::class,[
                'label' => 'Ort',
				'required' => true
            ])
            ->add('phone',TextType::class,[
                'label' => 'Telefon',
				'required' => false
            ])
            ->add('email',EmailType::class,[
                'label' => 'E-Mail Adresse',
				'required' => false
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
