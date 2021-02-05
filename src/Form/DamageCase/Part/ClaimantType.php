<?php

namespace App\Form\DamageCase\Part;

use App\Entity\DamageCase\Part\Claimant\Claimant;
use App\Entity\DamageCase\Part\Claimant\ClaimantTyp;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClaimantType extends AbstractType
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
            ->add('typ',EntityType::class,[
                'label' => 'Ist der Anspruchsteller',
                'class' => ClaimantTyp::class,
                'choice_label' => 'name',
                'required' => false
            ])
            ->add('kindOfRelationship', TextType::class, [
                'label' => 'Art des Verwandtschafts-, Angestellten oder Vertragsverhältnisses',
                'required' => false
            ])
            ->add('isInDomesticCommunityWithMe', ChoiceType::class, [
                'label' => 'Lebt der Anspruchsteller mit Ihnen in häuslicher Gemeinschaft',
                'choices' => [
                    'Ja' => true,
                    'Nein' => false
                ],
                'multiple' => false,
                'expanded' => true,
                'attr' => [
                    'class' => 'line four-per-line wrap-checkboxes'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Claimant::class,
        ]);
    }
}
