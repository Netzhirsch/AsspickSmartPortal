<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GeneralSitesController extends AbstractController
{

	/**
	 * @Route("/impressum", name="impressum")
	 * @return Response
	 */
	public function impressumAction(
	): Response
	{
		return $this->render('_general/impressum.html.twig', []);
	}

	/**
	 * @Route("/datenschutz", name="datenschutz")
	 * @return Response
	 */
	public function datenschutzAction(
	): Response
	{
		return $this->render('_general/datenschutz.html.twig', []);
	}

}
