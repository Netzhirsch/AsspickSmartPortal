<?php

namespace App\Controller;

use App\Entity\InsurancePremiumDetermination;
use App\Form\InsurancePremiumDeterminationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/insurance_premium_determination")
 */
class InsurancePremiumDeterminationController extends AbstractController {
	use ControllerTrait;

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



		if ($form->isSubmitted() && $form->isValid()) {

			switch ($insurancePremiumDetermination->getMode()) {
				case InsurancePremiumDetermination::MODE_BAK_I:
					$gebaeudedeckung_mindestbeitrag_faktor = 0.80;
					$gebaeudedeckung_inklusive_graffiti_faktor = 0.85;
					$gebaeudedeckung_inklusive_verzicht_faktor = 0.90;
					break;
				case InsurancePremiumDetermination::MODE_BAK_III:
					$gebaeudedeckung_mindestbeitrag_faktor = 1.60;
					$gebaeudedeckung_inklusive_graffiti_faktor = 1.65;
					$gebaeudedeckung_inklusive_verzicht_faktor = 1.70;
					break;
				case InsurancePremiumDetermination::MODE_BAK_IV_MAX_2_5_MIO:
					$gebaeudedeckung_mindestbeitrag_faktor = 1.05;
					$gebaeudedeckung_inklusive_graffiti_faktor = 1.10;
					$gebaeudedeckung_inklusive_verzicht_faktor = 1.15;
					break;
				case InsurancePremiumDetermination::MODE_BAK_IV_OVER_2_5_MIO:
					$gebaeudedeckung_mindestbeitrag_faktor = 0.91;
					$gebaeudedeckung_inklusive_graffiti_faktor = 0.96;
					$gebaeudedeckung_inklusive_verzicht_faktor = 1.01;
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
			'gebaeudedeckung_inklusive_verzicht_faktor' => $gebaeudedeckung_inklusive_verzicht_faktor
		];
		return $this->render('insurance_premium_determination/index.html.twig', $parameters);
	}
}
