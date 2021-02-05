<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class DashboardController
	extends AbstractController {

	/**
	 * @Route("/", name="dashboard")
	 * @return Response
	 */
	public function dashboardAction(): Response
    {

		$parameters = [];

		return $this->render('dashboard/index.html.twig', $parameters);
	}

	/**
	 * @Route("/files", name="files")
	 * @return Response
	 */
	public function filesAction(): Response
    {

		$parameters = [];

		return $this->render('files/index.html.twig', $parameters);
	}
}
