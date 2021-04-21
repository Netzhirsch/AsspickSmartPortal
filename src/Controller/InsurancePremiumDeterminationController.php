<?php

namespace App\Controller;

use App\Controller\DamageCase\DamageCaseController;
use App\Entity\InsurancePremiumDetermination;
use App\Entity\User;
use App\Form\InsurancePremiumDeterminationType;
use App\PDF\InsurancePremiumDeterminationPDF;
use App\Struct\Email;
use Swift_Mailer;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/insurance_premium_determination")
 */
class InsurancePremiumDeterminationController extends DamageCaseController {
	use ControllerTrait;

    private Swift_Mailer $mailer;

	public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
        parent::__construct($mailer);
    }

    /**
	 * @Route("/", name="insurance_premium_determination_index")
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function indexAction(Request $request):Response {
		$insurancePremiumDetermination = new InsurancePremiumDetermination();
		$form = $this->createForm(InsurancePremiumDeterminationType::class, $insurancePremiumDetermination);

		$form->handleRequest($request);

		$gebaeudedeckung_mindestbeitrag_netto = null;
		$gebaeudedeckung_mindestbeitrag_brutto = null;
		$gebaeudedeckung_mindestbeitrag_faktor = null;

		$gebaeudedeckung_inklusive_graffiti_netto = null;
		$gebaeudedeckung_inklusive_graffiti_brutto = null;
		$gebaeudedeckung_inklusive_graffiti_faktor = null;

		$gebaeudedeckung_inklusive_verzicht_netto = null;
		$gebaeudedeckung_inklusive_verzicht_brutto = null;
		$gebaeudedeckung_inklusive_verzicht_faktor = null;

		$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_1_netto = null;
		$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_1_brutto = null;
		$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_1_faktor = null;

		$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_2_netto = null;
		$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_2_brutto = null;
		$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_2_faktor = null;

		$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_3_netto = null;
		$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_3_brutto = null;
		$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_3_faktor = null;

		$gebaeudedeckung_mit_elementar_1_netto = null;
		$gebaeudedeckung_mit_elementar_1_brutto = null;
		$gebaeudedeckung_mit_elementar_1_faktor = null;

		$gebaeudedeckung_mit_elementar_2_netto = null;
		$gebaeudedeckung_mit_elementar_2_brutto = null;
		$gebaeudedeckung_mit_elementar_2_faktor = null;

		$gebaeudedeckung_mit_elementar_3_netto = null;
		$gebaeudedeckung_mit_elementar_3_brutto = null;
		$gebaeudedeckung_mit_elementar_3_faktor = null;

		$gebaeudedeckung_komplett_ohne_gefahren_1_netto = null;
		$gebaeudedeckung_komplett_ohne_gefahren_1_brutto = null;
		$gebaeudedeckung_komplett_ohne_gefahren_1_faktor = null;

		$gebaeudedeckung_komplett_ohne_gefahren_2_netto = null;
		$gebaeudedeckung_komplett_ohne_gefahren_2_brutto = null;
		$gebaeudedeckung_komplett_ohne_gefahren_2_faktor = null;

		$gebaeudedeckung_komplett_ohne_gefahren_3_netto = null;
		$gebaeudedeckung_komplett_ohne_gefahren_3_brutto = null;
		$gebaeudedeckung_komplett_ohne_gefahren_3_faktor = null;

		$gebaeudedeckung_komplett_mit_gefahren_1_netto = null;
		$gebaeudedeckung_komplett_mit_gefahren_1_brutto = null;
		$gebaeudedeckung_komplett_mit_gefahren_1_faktor = null;

		$gebaeudedeckung_komplett_mit_gefahren_2_netto = null;
		$gebaeudedeckung_komplett_mit_gefahren_2_brutto = null;
		$gebaeudedeckung_komplett_mit_gefahren_2_faktor = null;

		$gebaeudedeckung_komplett_mit_gefahren_3_netto = null;
		$gebaeudedeckung_komplett_mit_gefahren_3_brutto = null;
		$gebaeudedeckung_komplett_mit_gefahren_3_faktor = null;

		$bauleistungsversicherung_1_netto = null;
		$bauleistungsversicherung_1_brutto = null;
		$bauleistungsversicherung_1_faktor = null;

		$bauleistungsversicherung_2_netto = null;
		$bauleistungsversicherung_2_brutto = null;
		$bauleistungsversicherung_2_faktor = null;

		$bauherrenhaftpflicht_netto = null;
		$bauherrenhaftpflicht_brutto = null;
		$bauherrenhaftpflicht_faktor = null;

		$haus_und_grundbesitzerhaftpflicht_1_netto = null;
		$haus_und_grundbesitzerhaftpflicht_1_brutto = null;

		$haus_und_grundbesitzerhaftpflicht_2_netto = null;
		$haus_und_grundbesitzerhaftpflicht_2_brutto = null;

		$gewaesserschadenhaftpflicht_1_netto = null;
		$gewaesserschadenhaftpflicht_1_brutto = null;

		$gewaesserschadenhaftpflicht_2_netto = null;
		$gewaesserschadenhaftpflicht_2_brutto = null;

		if ($form->isSubmitted() && $form->isValid()) {

			switch ($insurancePremiumDetermination->getMode()) {
				case InsurancePremiumDetermination::MODE_BAK_I:
					$gebaeudedeckung_mindestbeitrag_faktor = 0.80;
					$gebaeudedeckung_inklusive_graffiti_faktor = 0.85;
					$gebaeudedeckung_inklusive_verzicht_faktor = 0.90;
					$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_1_faktor = 0.94;
					$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_2_faktor = 0.99;
					$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_3_faktor = 1.04;
					$gebaeudedeckung_mit_elementar_1_faktor = 1.00;
					$gebaeudedeckung_mit_elementar_2_faktor = 1.05;
					$gebaeudedeckung_mit_elementar_3_faktor = 1.10;
					$gebaeudedeckung_komplett_ohne_gefahren_1_faktor = 1.14;
					$gebaeudedeckung_komplett_ohne_gefahren_2_faktor = 1.19;
					$gebaeudedeckung_komplett_ohne_gefahren_3_faktor = 1.24;
					$gebaeudedeckung_komplett_mit_gefahren_1_faktor = 1.28;
					$gebaeudedeckung_komplett_mit_gefahren_2_faktor = 1.33;
					$gebaeudedeckung_komplett_mit_gefahren_3_faktor = 1.38;
					$bauleistungsversicherung_1_faktor = 0.90;
					$bauleistungsversicherung_2_faktor = 1.05;
					$bauherrenhaftpflicht_faktor = 0.40;
					break;
				case InsurancePremiumDetermination::MODE_BAK_III:
					$gebaeudedeckung_mindestbeitrag_faktor = 1.60;
					$gebaeudedeckung_inklusive_graffiti_faktor = 1.65;
					$gebaeudedeckung_inklusive_verzicht_faktor = 1.70;
					$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_1_faktor = 1.74;
					$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_2_faktor = 1.79;
					$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_3_faktor = 1.84;
					$gebaeudedeckung_mit_elementar_1_faktor = 1.80;
					$gebaeudedeckung_mit_elementar_2_faktor = 1.85;
					$gebaeudedeckung_mit_elementar_3_faktor = 1.90;
					$gebaeudedeckung_komplett_ohne_gefahren_1_faktor = 1.94;
					$gebaeudedeckung_komplett_ohne_gefahren_2_faktor = 1.99;
					$gebaeudedeckung_komplett_ohne_gefahren_3_faktor = 2.04;
					$gebaeudedeckung_komplett_mit_gefahren_1_faktor = 2.08;
					$gebaeudedeckung_komplett_mit_gefahren_2_faktor = 2.13;
					$gebaeudedeckung_komplett_mit_gefahren_3_faktor = 2.18;
					$bauleistungsversicherung_1_faktor = 0.90;
					$bauleistungsversicherung_2_faktor = 1.05;
					$bauherrenhaftpflicht_faktor = 0.40;
					break;
				case InsurancePremiumDetermination::MODE_BAK_IV_MAX_2_5_MIO:
					$gebaeudedeckung_mindestbeitrag_faktor = 1.05;
					$gebaeudedeckung_inklusive_graffiti_faktor = 1.10;
					$gebaeudedeckung_inklusive_verzicht_faktor = 1.15;
					$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_1_faktor = 1.19;
					$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_2_faktor = 1.24;
					$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_3_faktor = 1.29;
					$gebaeudedeckung_mit_elementar_1_faktor = 1.25;
					$gebaeudedeckung_mit_elementar_2_faktor = 1.30;
					$gebaeudedeckung_mit_elementar_3_faktor = 1.35;
					$gebaeudedeckung_komplett_ohne_gefahren_1_faktor = 1.39;
					$gebaeudedeckung_komplett_ohne_gefahren_2_faktor = 1.44;
					$gebaeudedeckung_komplett_ohne_gefahren_3_faktor = 1.49;
					$gebaeudedeckung_komplett_mit_gefahren_1_faktor = 1.53;
					$gebaeudedeckung_komplett_mit_gefahren_2_faktor = 1.58;
					$gebaeudedeckung_komplett_mit_gefahren_3_faktor = 1.63;
					$bauleistungsversicherung_1_faktor = 0.90;
					$bauleistungsversicherung_2_faktor = 1.05;
					$bauherrenhaftpflicht_faktor = 0.40;
					break;
				case InsurancePremiumDetermination::MODE_BAK_IV_OVER_2_5_MIO:
					$gebaeudedeckung_mindestbeitrag_faktor = 0.91;
					$gebaeudedeckung_inklusive_graffiti_faktor = 0.96;
					$gebaeudedeckung_inklusive_verzicht_faktor = 1.01;
					$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_1_faktor = 1.05;
					$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_2_faktor = 1.10;
					$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_3_faktor = 1.15;
					$gebaeudedeckung_mit_elementar_1_faktor = 1.11;
					$gebaeudedeckung_mit_elementar_2_faktor = 1.16;
					$gebaeudedeckung_mit_elementar_3_faktor = 1.21;
					$gebaeudedeckung_komplett_ohne_gefahren_1_faktor = 1.25;
					$gebaeudedeckung_komplett_ohne_gefahren_2_faktor = 1.30;
					$gebaeudedeckung_komplett_ohne_gefahren_3_faktor = 1.35;
					$gebaeudedeckung_komplett_mit_gefahren_1_faktor = 1.39;
					$gebaeudedeckung_komplett_mit_gefahren_2_faktor = 1.44;
					$gebaeudedeckung_komplett_mit_gefahren_3_faktor = 1.49;
					$bauleistungsversicherung_1_faktor = 0.90;
					$bauleistungsversicherung_2_faktor = 1.05;
					$bauherrenhaftpflicht_faktor = 0.40;
					break;
				case InsurancePremiumDetermination::MODE_DENKMALSCHUTZ:
					$gebaeudedeckung_mindestbeitrag_faktor = 0.92;
					$gebaeudedeckung_inklusive_graffiti_faktor = 0.97;
					$gebaeudedeckung_inklusive_verzicht_faktor = 1.02;
					$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_1_faktor = 1.06;
					$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_2_faktor = 1.11;
					$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_3_faktor = 1.16;
					$gebaeudedeckung_mit_elementar_1_faktor = 1.12;
					$gebaeudedeckung_mit_elementar_2_faktor = 1.17;
					$gebaeudedeckung_mit_elementar_3_faktor = 1.22;
					$gebaeudedeckung_komplett_ohne_gefahren_1_faktor = 1.26;
					$gebaeudedeckung_komplett_ohne_gefahren_2_faktor = 1.31;
					$gebaeudedeckung_komplett_ohne_gefahren_3_faktor = 1.36;
					$gebaeudedeckung_komplett_mit_gefahren_1_faktor = 1.40;
					$gebaeudedeckung_komplett_mit_gefahren_2_faktor = 1.45;
					$gebaeudedeckung_komplett_mit_gefahren_3_faktor = 1.50;
					$bauleistungsversicherung_1_faktor = 0.90;
					$bauleistungsversicherung_2_faktor = 1.05;
					$bauherrenhaftpflicht_faktor = 0.40;
					break;
				case InsurancePremiumDetermination::MODE_FERIENHAUS:
					$gebaeudedeckung_mindestbeitrag_faktor = 0.96;
					$gebaeudedeckung_inklusive_graffiti_faktor = 1.01;
					$gebaeudedeckung_inklusive_verzicht_faktor = 1.06;
					$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_1_faktor = 1.10;
					$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_2_faktor = 1.15;
					$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_3_faktor = 1.20;
					$gebaeudedeckung_mit_elementar_1_faktor = 1.16;
					$gebaeudedeckung_mit_elementar_2_faktor = 1.21;
					$gebaeudedeckung_mit_elementar_3_faktor = 1.26;
					$gebaeudedeckung_komplett_ohne_gefahren_1_faktor = 1.30;
					$gebaeudedeckung_komplett_ohne_gefahren_2_faktor = 1.35;
					$gebaeudedeckung_komplett_ohne_gefahren_3_faktor = 1.40;
					$gebaeudedeckung_komplett_mit_gefahren_1_faktor = 1.44;
					$gebaeudedeckung_komplett_mit_gefahren_2_faktor = 1.49;
					$gebaeudedeckung_komplett_mit_gefahren_3_faktor = 1.54;
					$bauleistungsversicherung_1_faktor = 0.90;
					$bauleistungsversicherung_2_faktor = 1.05;
					$bauherrenhaftpflicht_faktor = 0.40;
					break;
			}

			$gebaeudedeckung_mindestbeitrag_netto = max(120, $insurancePremiumDetermination->getTotal() * $gebaeudedeckung_mindestbeitrag_faktor * 1.55 / 1000);
			$gebaeudedeckung_mindestbeitrag_brutto = $gebaeudedeckung_mindestbeitrag_netto * 1.1634;
			$gebaeudedeckung_mindestbeitrag_netto = number_format($gebaeudedeckung_mindestbeitrag_netto, 2, ",", ".");
			$gebaeudedeckung_mindestbeitrag_brutto = number_format($gebaeudedeckung_mindestbeitrag_brutto, 2, ",", ".");
			$gebaeudedeckung_mindestbeitrag_faktor = number_format($gebaeudedeckung_mindestbeitrag_faktor, 2, ",", ".");

			$gebaeudedeckung_inklusive_graffiti_netto = max(120, $insurancePremiumDetermination->getTotal() * $gebaeudedeckung_inklusive_graffiti_faktor * 1.55 / 1000);
			$gebaeudedeckung_inklusive_graffiti_brutto = $gebaeudedeckung_inklusive_graffiti_netto * 1.1634;
			$gebaeudedeckung_inklusive_graffiti_netto = number_format($gebaeudedeckung_inklusive_graffiti_netto, 2, ",", ".");
			$gebaeudedeckung_inklusive_graffiti_brutto = number_format($gebaeudedeckung_inklusive_graffiti_brutto, 2, ",", ".");
			$gebaeudedeckung_inklusive_graffiti_faktor = number_format($gebaeudedeckung_inklusive_graffiti_faktor, 2, ",", ".");

			$gebaeudedeckung_inklusive_verzicht_netto = max(120, $insurancePremiumDetermination->getTotal() * $gebaeudedeckung_inklusive_verzicht_faktor * 1.55 / 1000);
			$gebaeudedeckung_inklusive_verzicht_brutto = $gebaeudedeckung_inklusive_verzicht_netto * 1.1634;
			$gebaeudedeckung_inklusive_verzicht_netto = number_format($gebaeudedeckung_inklusive_verzicht_netto, 2, ",", ".");
			$gebaeudedeckung_inklusive_verzicht_brutto = number_format($gebaeudedeckung_inklusive_verzicht_brutto, 2, ",", ".");
			$gebaeudedeckung_inklusive_verzicht_faktor = number_format($gebaeudedeckung_inklusive_verzicht_faktor, 2, ",", ".");

			$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_1_netto = max(120, $insurancePremiumDetermination->getTotal() * $gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_1_faktor * 1.55 / 1000);
			$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_1_brutto = $gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_1_netto * 1.1634;
			$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_1_netto = number_format($gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_1_netto, 2, ",", ".");
			$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_1_brutto = number_format($gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_1_brutto, 2, ",", ".");
			$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_1_faktor = number_format($gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_1_faktor, 2, ",", ".");

			$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_2_netto = max(120, $insurancePremiumDetermination->getTotal() * $gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_2_faktor * 1.55 / 1000);
			$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_2_brutto = $gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_2_netto * 1.1634;
			$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_2_netto = number_format($gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_2_netto, 2, ",", ".");
			$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_2_brutto = number_format($gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_2_brutto, 2, ",", ".");
			$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_2_faktor = number_format($gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_2_faktor, 2, ",", ".");

			$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_3_netto = max(120, $insurancePremiumDetermination->getTotal() * $gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_3_faktor * 1.55 / 1000);
			$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_3_brutto = $gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_3_netto * 1.1634;
			$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_3_netto = number_format($gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_3_netto, 2, ",", ".");
			$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_3_brutto = number_format($gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_3_brutto, 2, ",", ".");
			$gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_3_faktor = number_format($gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_3_faktor, 2, ",", ".");

			$gebaeudedeckung_mit_elementar_1_netto = max(120, $insurancePremiumDetermination->getTotal() * $gebaeudedeckung_mit_elementar_1_faktor * 1.55 / 1000);
			$gebaeudedeckung_mit_elementar_1_brutto = $gebaeudedeckung_mit_elementar_1_netto * 1.1634;
			$gebaeudedeckung_mit_elementar_1_netto = number_format($gebaeudedeckung_mit_elementar_1_netto, 2, ",", ".");
			$gebaeudedeckung_mit_elementar_1_brutto = number_format($gebaeudedeckung_mit_elementar_1_brutto, 2, ",", ".");
			$gebaeudedeckung_mit_elementar_1_faktor = number_format($gebaeudedeckung_mit_elementar_1_faktor, 2, ",", ".");

			$gebaeudedeckung_mit_elementar_2_netto = max(120, $insurancePremiumDetermination->getTotal() * $gebaeudedeckung_mit_elementar_2_faktor * 1.55 / 1000);
			$gebaeudedeckung_mit_elementar_2_brutto = $gebaeudedeckung_mit_elementar_2_netto * 1.1634;
			$gebaeudedeckung_mit_elementar_2_netto = number_format($gebaeudedeckung_mit_elementar_2_netto, 2, ",", ".");
			$gebaeudedeckung_mit_elementar_2_brutto = number_format($gebaeudedeckung_mit_elementar_2_brutto, 2, ",", ".");
			$gebaeudedeckung_mit_elementar_2_faktor = number_format($gebaeudedeckung_mit_elementar_2_faktor, 2, ",", ".");

			$gebaeudedeckung_mit_elementar_3_netto = max(120, $insurancePremiumDetermination->getTotal() * $gebaeudedeckung_mit_elementar_3_faktor * 1.55 / 1000);
			$gebaeudedeckung_mit_elementar_3_brutto = $gebaeudedeckung_mit_elementar_3_netto * 1.1634;
			$gebaeudedeckung_mit_elementar_3_netto = number_format($gebaeudedeckung_mit_elementar_3_netto, 2, ",", ".");
			$gebaeudedeckung_mit_elementar_3_brutto = number_format($gebaeudedeckung_mit_elementar_3_brutto, 2, ",", ".");
			$gebaeudedeckung_mit_elementar_3_faktor = number_format($gebaeudedeckung_mit_elementar_3_faktor, 2, ",", ".");

			$gebaeudedeckung_komplett_ohne_gefahren_1_netto = max(120, $insurancePremiumDetermination->getTotal() * $gebaeudedeckung_komplett_ohne_gefahren_1_faktor * 1.55 / 1000);
			$gebaeudedeckung_komplett_ohne_gefahren_1_brutto = $gebaeudedeckung_komplett_ohne_gefahren_1_netto * 1.1634;
			$gebaeudedeckung_komplett_ohne_gefahren_1_netto = number_format($gebaeudedeckung_komplett_ohne_gefahren_1_netto, 2, ",", ".");
			$gebaeudedeckung_komplett_ohne_gefahren_1_brutto = number_format($gebaeudedeckung_komplett_ohne_gefahren_1_brutto, 2, ",", ".");
			$gebaeudedeckung_komplett_ohne_gefahren_1_faktor = number_format($gebaeudedeckung_komplett_ohne_gefahren_1_faktor, 2, ",", ".");

			$gebaeudedeckung_komplett_ohne_gefahren_2_netto = max(120, $insurancePremiumDetermination->getTotal() * $gebaeudedeckung_komplett_ohne_gefahren_2_faktor * 1.55 / 1000);
			$gebaeudedeckung_komplett_ohne_gefahren_2_brutto = $gebaeudedeckung_komplett_ohne_gefahren_2_netto * 1.1634;
			$gebaeudedeckung_komplett_ohne_gefahren_2_netto = number_format($gebaeudedeckung_komplett_ohne_gefahren_2_netto, 2, ",", ".");
			$gebaeudedeckung_komplett_ohne_gefahren_2_brutto = number_format($gebaeudedeckung_komplett_ohne_gefahren_2_brutto, 2, ",", ".");
			$gebaeudedeckung_komplett_ohne_gefahren_2_faktor = number_format($gebaeudedeckung_komplett_ohne_gefahren_2_faktor, 2, ",", ".");

			$gebaeudedeckung_komplett_ohne_gefahren_3_netto = max(120, $insurancePremiumDetermination->getTotal() * $gebaeudedeckung_komplett_ohne_gefahren_3_faktor * 1.55 / 1000);
			$gebaeudedeckung_komplett_ohne_gefahren_3_brutto = $gebaeudedeckung_komplett_ohne_gefahren_3_netto * 1.1634;
			$gebaeudedeckung_komplett_ohne_gefahren_3_netto = number_format($gebaeudedeckung_komplett_ohne_gefahren_3_netto, 2, ",", ".");
			$gebaeudedeckung_komplett_ohne_gefahren_3_brutto = number_format($gebaeudedeckung_komplett_ohne_gefahren_3_brutto, 2, ",", ".");
			$gebaeudedeckung_komplett_ohne_gefahren_3_faktor = number_format($gebaeudedeckung_komplett_ohne_gefahren_3_faktor, 2, ",", ".");

			$gebaeudedeckung_komplett_mit_gefahren_1_netto = max(120, $insurancePremiumDetermination->getTotal() * $gebaeudedeckung_komplett_mit_gefahren_1_faktor * 1.55 / 1000);
			$gebaeudedeckung_komplett_mit_gefahren_1_brutto = $gebaeudedeckung_komplett_mit_gefahren_1_netto * 1.1634;
			$gebaeudedeckung_komplett_mit_gefahren_1_netto = number_format($gebaeudedeckung_komplett_mit_gefahren_1_netto, 2, ",", ".");
			$gebaeudedeckung_komplett_mit_gefahren_1_brutto = number_format($gebaeudedeckung_komplett_mit_gefahren_1_brutto, 2, ",", ".");
			$gebaeudedeckung_komplett_mit_gefahren_1_faktor = number_format($gebaeudedeckung_komplett_mit_gefahren_1_faktor, 2, ",", ".");

			$gebaeudedeckung_komplett_mit_gefahren_2_netto = max(120, $insurancePremiumDetermination->getTotal() * $gebaeudedeckung_komplett_mit_gefahren_2_faktor * 1.55 / 1000);
			$gebaeudedeckung_komplett_mit_gefahren_2_brutto = $gebaeudedeckung_komplett_mit_gefahren_2_netto * 1.1634;
			$gebaeudedeckung_komplett_mit_gefahren_2_netto = number_format($gebaeudedeckung_komplett_mit_gefahren_2_netto, 2, ",", ".");
			$gebaeudedeckung_komplett_mit_gefahren_2_brutto = number_format($gebaeudedeckung_komplett_mit_gefahren_2_brutto, 2, ",", ".");
			$gebaeudedeckung_komplett_mit_gefahren_2_faktor = number_format($gebaeudedeckung_komplett_mit_gefahren_2_faktor, 2, ",", ".");

			$gebaeudedeckung_komplett_mit_gefahren_3_netto = max(120, $insurancePremiumDetermination->getTotal() * $gebaeudedeckung_komplett_mit_gefahren_3_faktor * 1.55 / 1000);
			$gebaeudedeckung_komplett_mit_gefahren_3_brutto = $gebaeudedeckung_komplett_mit_gefahren_3_netto * 1.1634;
			$gebaeudedeckung_komplett_mit_gefahren_3_netto = number_format($gebaeudedeckung_komplett_mit_gefahren_3_netto, 2, ",", ".");
			$gebaeudedeckung_komplett_mit_gefahren_3_brutto = number_format($gebaeudedeckung_komplett_mit_gefahren_3_brutto, 2, ",", ".");
			$gebaeudedeckung_komplett_mit_gefahren_3_faktor = number_format($gebaeudedeckung_komplett_mit_gefahren_3_faktor, 2, ",", ".");

			$bauleistungsversicherung_1_netto = 0;
			if (!empty($insurancePremiumDetermination->getCurrentValue()))
				$bauleistungsversicherung_1_netto = max(250, $insurancePremiumDetermination->getCurrentValue() * $bauleistungsversicherung_1_faktor / 1000);
			$bauleistungsversicherung_1_brutto = $bauleistungsversicherung_1_netto * 1.19;
			$bauleistungsversicherung_1_netto = number_format($bauleistungsversicherung_1_netto, 2, ",", ".");
			$bauleistungsversicherung_1_brutto = number_format($bauleistungsversicherung_1_brutto, 2, ",", ".");
			$bauleistungsversicherung_1_faktor = number_format($bauleistungsversicherung_1_faktor, 2, ",", ".");

			$bauleistungsversicherung_2_netto = 0;
			if (!empty($insurancePremiumDetermination->getCurrentValue()))
				$bauleistungsversicherung_2_netto = max(250, $insurancePremiumDetermination->getCurrentValue() * $bauleistungsversicherung_2_faktor / 1000);
			$bauleistungsversicherung_2_brutto = $bauleistungsversicherung_2_netto * 1.19;
			$bauleistungsversicherung_2_netto = number_format($bauleistungsversicherung_2_netto, 2, ",", ".");
			$bauleistungsversicherung_2_brutto = number_format($bauleistungsversicherung_2_brutto, 2, ",", ".");
			$bauleistungsversicherung_2_faktor = number_format($bauleistungsversicherung_2_faktor, 2, ",", ".");

			$bauherrenhaftpflicht_netto = 0;
			if (!empty($insurancePremiumDetermination->getCurrentValue()))
				$bauherrenhaftpflicht_netto = max(50, $insurancePremiumDetermination->getCurrentValue() * $bauherrenhaftpflicht_faktor / 1000);
			$bauherrenhaftpflicht_brutto = $bauherrenhaftpflicht_netto * 1.19;
			$bauherrenhaftpflicht_netto = number_format($bauherrenhaftpflicht_netto, 2, ",", ".");
			$bauherrenhaftpflicht_brutto = number_format($bauherrenhaftpflicht_brutto, 2, ",", ".");
			$bauherrenhaftpflicht_faktor = number_format($bauherrenhaftpflicht_faktor, 2, ",", ".");

			$haus_und_grundbesitzerhaftpflicht_1_netto = 0;
			if (!empty($insurancePremiumDetermination->getNumberOfResidentialUnits()) || !empty($insurancePremiumDetermination->getNumberOfCommerciallyUsedUnits()))
				$haus_und_grundbesitzerhaftpflicht_1_netto = max(50, $insurancePremiumDetermination->getNumberOfResidentialUnits() * 4 + $insurancePremiumDetermination->getNumberOfCommerciallyUsedUnits() * 8);
			$haus_und_grundbesitzerhaftpflicht_1_brutto = $haus_und_grundbesitzerhaftpflicht_1_netto * 1.19;
			$haus_und_grundbesitzerhaftpflicht_1_netto = number_format($haus_und_grundbesitzerhaftpflicht_1_netto, 2, ",", ".");
			$haus_und_grundbesitzerhaftpflicht_1_brutto = number_format($haus_und_grundbesitzerhaftpflicht_1_brutto, 2, ",", ".");

			$haus_und_grundbesitzerhaftpflicht_2_netto = 0;
			if (!empty($insurancePremiumDetermination->getNumberOfResidentialUnits()) || !empty($insurancePremiumDetermination->getNumberOfCommerciallyUsedUnits()))
				$haus_und_grundbesitzerhaftpflicht_2_netto = max(50, $insurancePremiumDetermination->getNumberOfResidentialUnits() * 5 + $insurancePremiumDetermination->getNumberOfCommerciallyUsedUnits() * 10);
			$haus_und_grundbesitzerhaftpflicht_2_brutto = $haus_und_grundbesitzerhaftpflicht_2_netto * 1.19;
			$haus_und_grundbesitzerhaftpflicht_2_netto = number_format($haus_und_grundbesitzerhaftpflicht_2_netto, 2, ",", ".");
			$haus_und_grundbesitzerhaftpflicht_2_brutto = number_format($haus_und_grundbesitzerhaftpflicht_2_brutto, 2, ",", ".");

			$gewaesserschadenhaftpflicht_1_netto = 0;
			if (!empty($insurancePremiumDetermination->getOilTankSize())) {
				if ($insurancePremiumDetermination->getOilTankSize() < 11) {
					$gewaesserschadenhaftpflicht_1_netto = 100;
					$gewaesserschadenhaftpflicht_2_netto = 139.53;
				} elseif ($insurancePremiumDetermination->getOilTankSize() < 31) {
					$gewaesserschadenhaftpflicht_1_netto = 220;
					$gewaesserschadenhaftpflicht_2_netto = 273.65;
				} elseif ($insurancePremiumDetermination->getOilTankSize() < 51) {
					$gewaesserschadenhaftpflicht_1_netto = 270;
					$gewaesserschadenhaftpflicht_2_netto = 335.44;
				} elseif ($insurancePremiumDetermination->getOilTankSize() < 101) {
					$gewaesserschadenhaftpflicht_1_netto = 340;
					$gewaesserschadenhaftpflicht_2_netto = 419.18;
				}

			}
			$gewaesserschadenhaftpflicht_1_brutto = $gewaesserschadenhaftpflicht_1_netto * 1.19;
			$gewaesserschadenhaftpflicht_1_netto = number_format($gewaesserschadenhaftpflicht_1_netto, 2, ",", ".");
			$gewaesserschadenhaftpflicht_1_brutto = number_format($gewaesserschadenhaftpflicht_1_brutto, 2, ",", ".");

			$gewaesserschadenhaftpflicht_2_brutto = $gewaesserschadenhaftpflicht_2_netto * 1.19;
			$gewaesserschadenhaftpflicht_2_netto = number_format($gewaesserschadenhaftpflicht_2_netto, 2, ",", ".");
			$gewaesserschadenhaftpflicht_2_brutto = number_format($gewaesserschadenhaftpflicht_2_brutto, 2, ",", ".");

		}


		$parameters = [
			'form' => $form->createView(),
			'gebaeudedeckung_mindestbeitrag_netto' => $gebaeudedeckung_mindestbeitrag_netto,
			'gebaeudedeckung_mindestbeitrag_brutto' => $gebaeudedeckung_mindestbeitrag_brutto,
			'gebaeudedeckung_mindestbeitrag_faktor' => $gebaeudedeckung_mindestbeitrag_faktor,
			'gebaeudedeckung_inklusive_graffiti_netto' => $gebaeudedeckung_inklusive_graffiti_netto,
			'gebaeudedeckung_inklusive_graffiti_brutto' => $gebaeudedeckung_inklusive_graffiti_brutto,
			'gebaeudedeckung_inklusive_graffiti_faktor' => $gebaeudedeckung_inklusive_graffiti_faktor,
			'gebaeudedeckung_inklusive_verzicht_netto' => $gebaeudedeckung_inklusive_verzicht_netto,
			'gebaeudedeckung_inklusive_verzicht_brutto' => $gebaeudedeckung_inklusive_verzicht_brutto,
			'gebaeudedeckung_inklusive_verzicht_faktor' => $gebaeudedeckung_inklusive_verzicht_faktor,
			'gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_1_netto' => $gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_1_netto,
			'gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_1_brutto' => $gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_1_brutto,
			'gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_1_faktor' => $gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_1_faktor,
			'gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_2_netto' => $gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_2_netto,
			'gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_2_brutto' => $gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_2_brutto,
			'gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_2_faktor' => $gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_2_faktor,
			'gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_3_netto' => $gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_3_netto,
			'gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_3_brutto' => $gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_3_brutto,
			'gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_3_faktor' => $gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_3_faktor,
			'gebaeudedeckung_mit_elementar_1_netto' => $gebaeudedeckung_mit_elementar_1_netto,
			'gebaeudedeckung_mit_elementar_1_brutto' => $gebaeudedeckung_mit_elementar_1_brutto,
			'gebaeudedeckung_mit_elementar_1_faktor' => $gebaeudedeckung_mit_elementar_1_faktor,
			'gebaeudedeckung_mit_elementar_2_netto' => $gebaeudedeckung_mit_elementar_2_netto,
			'gebaeudedeckung_mit_elementar_2_brutto' => $gebaeudedeckung_mit_elementar_2_brutto,
			'gebaeudedeckung_mit_elementar_2_faktor' => $gebaeudedeckung_mit_elementar_2_faktor,
			'gebaeudedeckung_mit_elementar_3_netto' => $gebaeudedeckung_mit_elementar_3_netto,
			'gebaeudedeckung_mit_elementar_3_brutto' => $gebaeudedeckung_mit_elementar_3_brutto,
			'gebaeudedeckung_mit_elementar_3_faktor' => $gebaeudedeckung_mit_elementar_3_faktor,
			'gebaeudedeckung_komplett_ohne_gefahren_1_netto' => $gebaeudedeckung_komplett_ohne_gefahren_1_netto,
			'gebaeudedeckung_komplett_ohne_gefahren_1_brutto' => $gebaeudedeckung_komplett_ohne_gefahren_1_brutto,
			'gebaeudedeckung_komplett_ohne_gefahren_1_faktor' => $gebaeudedeckung_komplett_ohne_gefahren_1_faktor,
			'gebaeudedeckung_komplett_ohne_gefahren_2_netto' => $gebaeudedeckung_komplett_ohne_gefahren_2_netto,
			'gebaeudedeckung_komplett_ohne_gefahren_2_brutto' => $gebaeudedeckung_komplett_ohne_gefahren_2_brutto,
			'gebaeudedeckung_komplett_ohne_gefahren_2_faktor' => $gebaeudedeckung_komplett_ohne_gefahren_2_faktor,
			'gebaeudedeckung_komplett_ohne_gefahren_3_netto' => $gebaeudedeckung_komplett_ohne_gefahren_3_netto,
			'gebaeudedeckung_komplett_ohne_gefahren_3_brutto' => $gebaeudedeckung_komplett_ohne_gefahren_3_brutto,
			'gebaeudedeckung_komplett_ohne_gefahren_3_faktor' => $gebaeudedeckung_komplett_ohne_gefahren_3_faktor,
			'gebaeudedeckung_komplett_mit_gefahren_1_netto' => $gebaeudedeckung_komplett_mit_gefahren_1_netto,
			'gebaeudedeckung_komplett_mit_gefahren_1_brutto' => $gebaeudedeckung_komplett_mit_gefahren_1_brutto,
			'gebaeudedeckung_komplett_mit_gefahren_1_faktor' => $gebaeudedeckung_komplett_mit_gefahren_1_faktor,
			'gebaeudedeckung_komplett_mit_gefahren_2_netto' => $gebaeudedeckung_komplett_mit_gefahren_2_netto,
			'gebaeudedeckung_komplett_mit_gefahren_2_brutto' => $gebaeudedeckung_komplett_mit_gefahren_2_brutto,
			'gebaeudedeckung_komplett_mit_gefahren_2_faktor' => $gebaeudedeckung_komplett_mit_gefahren_2_faktor,
			'gebaeudedeckung_komplett_mit_gefahren_3_netto' => $gebaeudedeckung_komplett_mit_gefahren_3_netto,
			'gebaeudedeckung_komplett_mit_gefahren_3_brutto' => $gebaeudedeckung_komplett_mit_gefahren_3_brutto,
			'gebaeudedeckung_komplett_mit_gefahren_3_faktor' => $gebaeudedeckung_komplett_mit_gefahren_3_faktor,
			'bauleistungsversicherung_1_netto' => $bauleistungsversicherung_1_netto,
			'bauleistungsversicherung_1_brutto' => $bauleistungsversicherung_1_brutto,
			'bauleistungsversicherung_1_faktor' => $bauleistungsversicherung_1_faktor,
			'bauleistungsversicherung_2_netto' => $bauleistungsversicherung_2_netto,
			'bauleistungsversicherung_2_brutto' => $bauleistungsversicherung_2_brutto,
			'bauleistungsversicherung_2_faktor' => $bauleistungsversicherung_2_faktor,
			'bauherrenhaftpflicht_netto' => $bauherrenhaftpflicht_netto,
			'bauherrenhaftpflicht_brutto' => $bauherrenhaftpflicht_brutto,
			'bauherrenhaftpflicht_faktor' => $bauherrenhaftpflicht_faktor,
			'haus_und_grundbesitzerhaftpflicht_1_netto' => $haus_und_grundbesitzerhaftpflicht_1_netto,
			'haus_und_grundbesitzerhaftpflicht_1_brutto' => $haus_und_grundbesitzerhaftpflicht_1_brutto,
			'haus_und_grundbesitzerhaftpflicht_2_netto' => $haus_und_grundbesitzerhaftpflicht_2_netto,
			'haus_und_grundbesitzerhaftpflicht_2_brutto' => $haus_und_grundbesitzerhaftpflicht_2_brutto,
			'gewaesserschadenhaftpflicht_1_netto' => $gewaesserschadenhaftpflicht_1_netto,
			'gewaesserschadenhaftpflicht_1_brutto' => $gewaesserschadenhaftpflicht_1_brutto,
			'gewaesserschadenhaftpflicht_2_netto' => $gewaesserschadenhaftpflicht_2_netto,
			'gewaesserschadenhaftpflicht_2_brutto' => $gewaesserschadenhaftpflicht_2_brutto,
		];

        /**@var SubmitButton $insureButton */
        $insureButton = $form->get('insure');
        if ($form->isSubmitted() && $form->isValid() && $insureButton->isClicked()) {
            $this->insure($parameters,$form->getData());
            $this->addFlash('success', 'Daten wurden an asspick übermittelt. 
            Sie erhalten ein E-Mail-Bestätigung.');
        }
        
		return $this->render('insurance_premium_determination/index.html.twig', $parameters);
	}

    private function insure(array $parameters,InsurancePremiumDetermination $insurancePremiumDetermination)
    {
        $insuredName = $insurancePremiumDetermination->getLastName().'_'.$insurancePremiumDetermination->getFirstName();
        $number = 0;
        $dir = $this->makeDir('insurance_premium_determination', $insuredName);

        $name = 'BVAW Gebäude.pdf';
        do {
            $number++;
            if ($number > 1 && $number > 10)
                $name = $number.'-'.$name;
            elseif($number > 1 && $number < 10)
                $name = '0'.$number.'-'.$name;

            $filePath = $dir.DIRECTORY_SEPARATOR.$name;
            $name = 'BVAW Gebäude.pdf';

        } while(file_exists($filePath));

        $pdfClass = InsurancePremiumDeterminationPDF::class;
        $pdf = new $pdfClass();
        $pdf->create($insurancePremiumDetermination,$parameters);

        $pdf->Output($filePath, 'F');

        $countReceiver = $this->sendEmailToAdmin($insurancePremiumDetermination, $filePath);

        $countReceiver += $this->sendEmailToUser($insurancePremiumDetermination, $filePath);

        if
        (
            $countReceiver != 2
        ) {
            $this->addFlash
            (
                'error'
                ,
                'Es konnte leider keine E-Mail versandt werden, 
                    bitte melden Sie sich direkt bei asspick@asspick.de'
            );
        }

    }

    private function sendEmailToAdmin(
        InsurancePremiumDetermination $insurancePremiumDetermination,
        string $filePath
    ): int
    {
        $email = new Email();
        $email->setSubject('BVAW Gebäude wurde eingereicht.');
        $email->setMessage(
            'BVAW Gebäude wurde von '.$insurancePremiumDetermination->getName().' eingereicht.'
        );
        $email->setTo('schaden@asspick.de');

        return $this->sendMailWithAttachment($this->mailer, $email, $filePath);
    }

    private function sendEmailToUser(
        InsurancePremiumDetermination $insurancePremiumDetermination,
        string $filePath
    ): int
    {
        $email = new Email();
        $email->setSalutation($insurancePremiumDetermination->getSalutation());
        $email->setName($insurancePremiumDetermination->getName());
        $email->setSubject('Sie haben BVAW Gebäude eingereicht.');
        $email->setMessage(
            'Danke das Sie BVAW Gebäude eingereicht haben.'
            .'Im Anhang finden Sie eine Kopie. Wir werden uns schnellstmöglich bei Ihnen melden.'
        );
        $this->setEmailToByUser($email);

        return $this->sendMailWithAttachment($this->mailer, $email, $filePath);
    }

    /**
     * @param Email $email
     */
    private function setEmailToByUser(Email $email): void
    {
        /** @var User $user */
        $user = $this->getUser();
        $email->setTo($user->getEmail());
    }
}
