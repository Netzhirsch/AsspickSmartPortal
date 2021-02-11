<?php

namespace App\Form\DamageCase\Car;

use App\Entity\DamageCase\Car\Driver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DriverType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname',TextType::class,[
                'label' => 'Vorname',
                'required' => false
            ])
            ->add('lastname',TextType::class,[
                'label' => 'Nachname',
                'required' => false
            ])
            ->add('streetMailbox',TextType::class,[
                'label' => 'Straße/Postfach',
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
            ->add('hasLicense', ChoiceType::class, [
                'label' => 'War der/die Fahrer(in) zum
Schadenzeitpunkt im Besitz einer gültigen Fahrerlaubnis?',
                'choices' => [
                    'Ja' => true,
                    'Nein' => false,
                ],
                'placeholder' => false,
                'multiple' => false,
                'expanded' => true,
                'attr' => [
                    'class' => 'line two-per-line wrap-checkboxes'
                ],
                'required' => false
            ])
            ->add('licenseClass', TextType::class, [
                'label' => 'Führerscheinklasse',
                'required' => false
            ])
            ->add('licenseNumber', TextType::class, [
                'label' => 'Führerschein-Nr.',
                'required' => false
            ])
            ->add('dateOfIssue',DateType::class,[
                'html5' => true,
                'widget' => 'single_text',
                'label' => 'Ausstellungsdatum',
                'required' => false
            ])
            ->add('exhibitionLocation', TextType::class, [
                'label' => 'Ausstellungsort',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Driver::class,
        ]);
    }
}
