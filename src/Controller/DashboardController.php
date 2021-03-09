<?php

namespace App\Controller;

use App\Entity\News;
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
        $em = $this->getDoctrine()->getManager();
        $repoNews = $em->getRepository(News::class);
        $newsroom = $repoNews->findBy([],['createdAt' => 'DESC'],4);
        foreach ($newsroom as $news) {
            foreach ($news->getFiles() as $file) {
                $path = $news::UPLOAD_FOLDER
                    .DIRECTORY_SEPARATOR
                    .$news->getCreatedAt()->format('Y-m-d')
                    .DIRECTORY_SEPARATOR
                    .$file->getName();
                $file->setPath($path);
            }
        }
        $parameters['newsroom'] = $newsroom;
		return $this->render('dashboard/index.html.twig', $parameters);
	}

	/**
	 * @Route("/files", name="files")
	 * @return Response
	 */
	public function filesAction(): Response
    {

		$parameters = [];

		return $this->render('files/index2.html.twig', $parameters);
	}
}
