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
		$parameters['form'] = $form->createView();
		return $this->render('insurance_premium_determination/index.html.twig', $parameters);
	}
}
