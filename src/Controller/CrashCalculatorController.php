<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/crash_calculator")
 */
class CrashCalculatorController
	extends AbstractController {

	/**
	 * @Route("/", name="crash_calculator")
	 * @return Response
	 */
	public function indexAction(): Response
    {
		return $this->render('crash_calculator/index.html.twig',[]);
	}
}