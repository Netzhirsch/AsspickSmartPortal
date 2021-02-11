<?php

namespace App\Form\DamageCase\GeneralDamage;

use App\Entity\DamageCase\GeneralDamage\BuildingDamage\BuildingDamage;
use App\Entity\DamageCase\GeneralDamage\BuildingDamage\RelationshipToBuilding;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BuildingDamageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('relationshipToBuilding', EntityType::class, [
                'label' => 'Sind Sie',
                'class' => RelationshipToBuilding::class,
                'choice_label' => 'name',
                'expanded' => true,
                'attr' => [
                    'class' => 'line two-per-line wrap-checkboxes'
                ],
                'required' => false,
                'placeholder' => false
            ])
            ->add('isDamageInRentedRooms', ChoiceType::class, [
                'label' => 'Ist der Schaden in Mieträumen eingetreten?',
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
            ->add('tenantFirstname',TextType::class,[
                'label' => 'Vorname des Mieters',
                'required' => false
            ])
            ->add('tenantLastname',TextType::class,[
                'label' => 'Nachname des Mieters',
                'required' => false
            ])
            ->add('homeInsurer',EmailType::class,[
                'label' => 'Hausratversicherer',
                'required' => false
            ])
            ->add('homeInsurerNumber',TextType::class,[
                'label' => 'Vers.-Schein-Nr.',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BuildingDamage::class,
        ]);
    }
}
