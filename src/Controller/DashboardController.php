<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
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
	 * @param EntityManagerInterface $em
	 * @return Response
	 */
	public function dashboardAction(EntityManagerInterface $em) {

		$parameters = [];

		return $this->render('dashboard/index.html.twig', $parameters);
	}

	/**
	 * @Route("/files", name="files")
	 * @param EntityManagerInterface $em
	 * @return Response
	 */
	public function filesAction(EntityManagerInterface $em) {

		$parameters = [];

		return $this->render('files/index.html.twig', $parameters);
	}
}
