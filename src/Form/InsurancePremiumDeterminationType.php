<?php

namespace App\Form;

use App\Entity\InsurancePremiumDetermination;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InsurancePremiumDeterminationType extends AbstractType {
	public function buildForm(FormBuilderInterface $builder, array $options) {

		$builder->add(
			'salutation',
			ChoiceType::class,
			[
				'label'       => 'Anrede',
				'choices'     => InsurancePremiumDetermination::getSalutationOptions(),
				'required'    => true,
				'placeholder' => '-',
				'attr' => [
					'tabindex' => 1
				]
			]
		);

		$builder->add(
			'firstName',
			TextType::class,
			[
				'label' => 'Vorname',
				'attr' => [
					'tabindex' => 2
				]
			]
		);

		$builder->add(
			'lastName',
			TextType::class,
			[
				'label' => 'Nachname',
				'attr' => [
					'tabindex' => 3
				]
			]
		);

		$builder->add(
			'street',
			TextType::class,
			[
				'label' => 'Straße',
				'attr' => [
					'tabindex' => 4
				]
			]
		);

		$builder->add(
			'zipcode',
			TextType::class,
			[
				'label' => 'Postleitzahl',
				'attr' => [
					'tabindex' => 5
				]
			]
		);

		$builder->add(
			'city',
			TextType::class,
			[
				'label' => 'Ort',
				'attr' => [
					'tabindex' => 6
				]
			]
		);

		$builder->add(
			'paymentMethod',
			ChoiceType::class,
			[
				'label'   => 'Zahlart',
				'choices' => InsurancePremiumDetermination::getPaymentMethods(),
				'required'    => true,
				'placeholder' => '-',
				'attr' => [
					'tabindex' => 7
				]
			]
		);

		$builder->add(
			'mode',
			ChoiceType::class,
			[
				'label'   => 'Modus',
				'choices' => InsurancePremiumDetermination::getModeOptions(),
				'attr' => [
					'tabindex' => 20
				]
			]
		);

		$builder->add(
			'sumInsured',
			NumberType::class,
			[
				'label'   => 'VS 1914',
				'html5' => true,
				'attr' => [
					'title' => 'Versicherungssumme Wert 1914 (in Mark)',
					'step' => 1,
					'min' => 1,
					'tabindex' => 21
				]
			]
		);

		$builder->add(
			'sumInsuredVs',
			NumberType::class,
			[
				'label'   => 'VS 2000',
				'html5' => false,
				'attr' => [
					'readonly' => true
				]
			]
		);

		$builder->add(
			'currentValue',
			NumberType::class,
			[
				'label'   => 'Wert aktuell',
				'html5' => true,
				'attr' => [
					'title' => 'Wiederherstellungs- oder Baukosten heute (in €)',
					'step' => 1,
					'min' => 0,
					'tabindex' => 22
				]
			]
		);

		$builder->add(
			'currentValueVs',
			NumberType::class,
			[
				'label'   => 'VS 2000',
				'html5' => false,
				'attr' => [
					'readonly' => true
				]
			]
		);

		$builder->add(
			'total',
			NumberType::class,
			[
				'label'   => 'VS 2000',
				'html5' => true,
				'attr' => [
					'step' => 1,
					'min' => 0,
					'tabindex' => 23
				]
			]
		);

		$builder->add(
			'totalVs',
			NumberType::class,
			[
				'label'   => 'VS aktuell',
				'html5' => false,
				'attr' => [
					'readonly' => true
				]
			]
		);

		$builder->add(
			'numberOfResidentialUnits',
			NumberType::class,
			[
				'label'   => 'Anzahl WE',
				'html5' => true,
				'attr' => [
					'title' => 'Anzahl Wohneinheiten',
					'step' => 1,
					'min' => 0,
					'tabindex' => 24
				]
			]
		);

		$builder->add(
			'numberOfCommerciallyUsedUnits',
			NumberType::class,
			[
				'label'   => 'Anzahl GE',
				'html5' => true,
				'attr' => [
					'title' => 'Anzahl gewerblich genutzter Einheiten',
					'step' => 1,
					'min' => 0,
					'tabindex' => 25
				]
			]
		);

		$builder->add(
			'oilTankSize',
			NumberType::class,
			[
				'label'   => 'Größe Öltank',
				'html5' => true,
				'attr' => [
					'step' => 1,
					'min' => 0,
					'tabindex' => 26
				]
			]
		);

		$builder->add(
			'submit',
			SubmitType::class,
			[
				'label'   => 'berechnen'
			]
		);

        $builder->add(
            'insure',
            SubmitType::class,
            [
                'label'   => 'versichern'
            ]
        );

	}

	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults(
			[
				'data_class' => InsurancePremiumDetermination::class,
			]
		);
	}
}
