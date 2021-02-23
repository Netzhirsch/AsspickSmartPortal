<?php

namespace App\Controller;

use App\Entity\News;
use App\Form\NewsType;
use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/news")
 */
class NewsController extends AbstractController
{
    use ControllerTrait;
    /**
     * @Route("/", name="news_index", methods={"GET"})
     * @param NewsRepository $newsRepository
     * @return Response
     */
    public function indexAction(NewsRepository $newsRepository): Response
    {

        return $this->render('news/index.html.twig', [
            'news' => $newsRepository->findBy([],['createdAt' => 'DESC'])
        ]);
    }

    /**
     * @Route("/new", name="news_new", methods={"GET","POST"})
     * @Route("/{id}/edit", name="news_edit", methods={"GET","POST"})
     * @param NewsRepository $newsRepository
     * @param Request $request
     * @param int|null $id
     * @return Response
     */
    public function formAction(NewsRepository $newsRepository,Request $request,int $id = null): Response
    {
        if (empty($id)) {
            $action = 'erstellen';
            $news = new News();
        } else {
            $action = 'bearbeiten';
            $news = $newsRepository->find($id);
            if (empty($news)) {
                $this->addFlashNotFound($id);
                return $this->redirectToRoute('news_index');
            }
        }
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $error = $this->saveUploadedPhotos($request,$news,$entityManager);
            if (!empty($error)) {
                $this->addFlash('error', $error);
            } else {
                $entityManager->persist($news);
                $entityManager->flush();
                $this->addFlash('success', 'News wurde erfolgreich gespeichert.');
            }
            return $this->redirectToRoute('news_index');
        }
        foreach ($news->getFiles() as $file) {
            $path = $news::UPLOAD_FOLDER
                .DIRECTORY_SEPARATOR
                .$news->getCreatedAt()->format('Y-m-d')
                .DIRECTORY_SEPARATOR
                .$file->getName();
                $file->setPath($path);
        }
        return $this->render('news/form.html.twig', [
            'action'    => $action,
            'news'      => $news,
            'form'      => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="news_delete", methods={"DELETE"})
     * @param NewsRepository $newsRepository
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function delete(NewsRepository $newsRepository,Request $request, int $id): Response
    {
        $news = $newsRepository->find($id);

        if (empty($news)) {
            $this->addFlashNotFound($id);
        } elseif ($this->isCsrfTokenValid('delete'.$news->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($news);
            $entityManager->flush();
            $this->addFlash('success', 'News '.$news->getTitel().' wurde erfolgreich gelöscht.');
        } else {
            $this->addFlash('error', 'Sicherheitsüberprüfung ist fehlgeschlagen bitte Sie es erneut.');
        }

        return $this->redirectToRoute('news_index');
    }

    private function addFlashNotFound(int $id){
        $this->addFlash(
            'error',
            'Kein News mit der Id: '.$id.' gefunden.'
        );
    }
}
