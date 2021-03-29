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
				'required'    => false,
				'placeholder' => '-',
			]
		);

		$builder->add(
			'firstName',
			TextType::class,
			[
				'label' => 'Vorname',
			]
		);

		$builder->add(
			'lastName',
			TextType::class,
			[
				'label' => 'Nachname',
			]
		);

		$builder->add(
			'mode',
			ChoiceType::class,
			[
				'label'   => 'Modus',
				'choices' => InsurancePremiumDetermination::getModeOptions(),
			]
		);

		$builder->add(
			'sumInsured',
			NumberType::class,
			[
				'label'   => 'VS 1941',
				'html5' => true,
				'attr' => [
					'title' => 'Versicherungssumme Wert 1941 (in Mio €)',
					'step' => 1,
					'min' => 1,
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
				]
			]
		);

		$builder->add(
			'total',
			NumberType::class,
			[
				'label'   => 'VS € 2000',
				'html5' => true,
				'attr' => [
					'step' => 1,
					'min' => 0,
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
				]
			]
		);

		$builder->add(
			'submit',
			SubmitType::class,
			[
				'label'   => 'Berechnen',
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
