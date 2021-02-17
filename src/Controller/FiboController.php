<?php

namespace App\Controller;

use App\Entity\Fibo;
use App\Entity\File;
use App\Form\FiboFileType;
use App\Form\FiboType;
use App\Repository\FiboRepository;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/fibo")
 */
class FiboController extends AbstractController
{
    /**
     * @Route("/", name="fibo_index", methods={"GET","POST"})
     * @param Request $request
     * @param FiboRepository $fiboRepository
     * @return Response
     */
    public function indexAction(
        Request $request,
        FiboRepository $fiboRepository
    ): Response
    {
        $file = new File();
        $file->setUploadAt((new DateTime()));
        $form = $this->createForm(FiboFileType::class, $file);
        $form->handleRequest($request);
        $fibos = $fiboRepository->findAll();
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            if (isset($form['file'])) {
                $this->readCsv($form, $fibos, $entityManager);
            }

            return $this->redirectToRoute('fibo_index');
        }

        return $this->render(
            'fibo/index.html.twig',
            [
                'fibos' => $fibos,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/new", name="fibo_new", methods={"GET","POST"})
     * @Route("/{id}/edit", name="fibo_edit", methods={"GET","POST"})
     * @param Request $request
     * @param FiboRepository $fiboRepository
     * @param int|null $id
     * @return Response
     */
    public function formAction(
        Request $request,
        FiboRepository $fiboRepository,
        int $id = null
    ): Response
    {
        if (empty($id)) {
            $action = 'erstellen';
            $fibo = new Fibo();
        } else {
            $action = 'bearbeiten';
            $fibo = $fiboRepository->find($id);
            if (empty($fibo)) {
                $this->notFoundFlash($id);
                $this->redirectToRoute('fibo_index');
            }

        }
        $form = $this->createForm(FiboType::class, $fibo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fibo);
            $entityManager->flush();

            return $this->redirectToRoute('fibo_index');
        }

        return $this->render(
            'fibo/form.html.twig',
            [
                'action' => $action,
                'fibo' => $fibo,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="fibo_delete", methods={"DELETE"})
     * @param Request $request
     * @param FiboRepository $fiboRepository
     * @param int $id
     * @return Response
     */
    public function deleteAction(
        Request $request,
        FiboRepository $fiboRepository,
        int $id
    ): Response
    {
        $fibo = $fiboRepository->find($id);
        if (empty($fibo)) {
            $this->notFoundFlash($id);
        } elseif ($this->isCsrfTokenValid('delete'.$fibo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fibo);
            $entityManager->flush();
        } else {
            $this->addFlash
            (
                'error',
                'Sicherheitsüberprüfung fehlgeschlagen bitte versuchen Sie es erneut.'
            );
        }

        return $this->redirectToRoute('fibo_index');
    }

    private function notFoundFlash($id)
    {
        $this->addFlash('error', 'Fibo Kürzel mit der Id:'.$id.' konnte nicht gefunden werden.');
    }

    /**
     * @param FormInterface $form
     * @param Fibo[] $fibos
     * @param ObjectManager $entityManager
     */
    private function readCsv(
        FormInterface $form,
        array $fibos,
        ObjectManager $entityManager
    ): void
    {
        /** @var UploadedFile $file */
        $file = $form['file']->getData();
        if (!$this->isCsv($file)) {
            $this->addFlash('error', 'Bitte nur CSV Dateien hochladen.');
            return;
        }

        $content = str_getcsv($file->getContent(), ';');
        foreach ($content as $key => $row) {
            if (!$this->isCodeRow($key, $row))
                continue;

            $code = $this->getSubStringBeforeNewLine($row);
            if (empty($code))
                continue;

            $isNew = true;
            foreach ($fibos as $fibo)
                if ($isNew = $fibo->getCode() == $code)
                    break;

            if (!$isNew)
                continue;
            $fibo = new Fibo();
            $fibo->setCode($code);
            $entityManager->persist($fibo);
        }
        $entityManager->flush();
    }

    private function isCsv(UploadedFile $file): bool
    {
        $mineType = $file->getMimeType();

        return $mineType == 'text/csv' || $mineType == 'text/plain';
    }

    private function isCodeRow(
        int $key,
        string $row
    ): bool
    {
        return $key > 5 && !empty($row) && $key % 6 == 0;
    }

    private function getSubStringBeforeNewLine(string $row): ?string
    {
        $temp = explode(PHP_EOL, $row);
        if (isset($temp[0])) {
            return $temp[0];
        } else {
            return null;
        }
    }
}
