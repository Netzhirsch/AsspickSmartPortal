<?php

namespace App\Controller;

use App\Entity\Fibu;
use App\Entity\File;
use App\Form\FibuFileType;
use App\Form\FibuType;
use App\Repository\FibuRepository;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/fibu")
 */
class FibuController extends AbstractController
{
    /**
     * @Route("/", name="fibu_index", methods={"GET","POST"})
     * @param Request $request
     * @param FibuRepository $fibuRepository
     * @return Response
     */
    public function indexAction(
        Request $request,
        FibuRepository $fibuRepository
    ): Response
    {
        $file = new File();
        $file->setUploadAt((new DateTime()));
        $form = $this->createForm(FibuFileType::class, $file);
        $form->handleRequest($request);
        $fibus = $fibuRepository->findAll();
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            if (isset($form['file'])) {
                $this->readCsv($form, $fibus, $entityManager);
            }

            return $this->redirectToRoute('fibu_index');
        }

        return $this->render(
            'fibu/index.html.twig',
            [
                'fibus' => $fibus,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/new", name="fibu_new", methods={"GET","POST"})
     * @Route("/{id}/edit", name="fibu_edit", methods={"GET","POST"})
     * @param Request $request
     * @param FibuRepository $fibuRepository
     * @param int|null $id
     * @return Response
     */
    public function formAction(
        Request $request,
        FibuRepository $fibuRepository,
        int $id = null
    ): Response
    {
        if (empty($id)) {
            $action = 'erstellen';
            $fibu = new Fibu();
        } else {
            $action = 'bearbeiten';
            $fibu = $fibuRepository->find($id);
            if (empty($fibu)) {
                $this->notFoundFlash($id);
                $this->redirectToRoute('fibu_index');
            }

        }
        $form = $this->createForm(FibuType::class, $fibu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fibu);
            $entityManager->flush();

            return $this->redirectToRoute('fibu_index');
        }

        return $this->render(
            'fibu/form.html.twig',
            [
                'action' => $action,
                'fibu' => $fibu,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="fibu_delete", methods={"DELETE"})
     * @param Request $request
     * @param FibuRepository $fibuRepository
     * @param int $id
     * @return Response
     */
    public function deleteAction(
        Request $request,
        FibuRepository $fibuRepository,
        int $id
    ): Response
    {
        $fibu = $fibuRepository->find($id);
        if (empty($fibu)) {
            $this->notFoundFlash($id);
        } elseif ($this->isCsrfTokenValid('delete'.$fibu->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fibu);
            $entityManager->flush();
        } else {
            $this->addFlash
            (
                'error',
                'Sicherheitsüberprüfung fehlgeschlagen bitte versuchen Sie es erneut.'
            );
        }

        return $this->redirectToRoute('fibu_index');
    }

    private function notFoundFlash($id)
    {
        $this->addFlash('error', 'Fibu Kürzel mit der Id:'.$id.' konnte nicht gefunden werden.');
    }

    /**
     * @param FormInterface $form
     * @param Fibu[] $fibus
     * @param ObjectManager $entityManager
     */
    private function readCsv(
        FormInterface $form,
        array $fibus,
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
            foreach ($fibus as $fibu)
                if ($isNew = $fibu->getCode() == $code)
                    break;

            if (!$isNew)
                continue;
            $fibu = new Fibu();
            $fibu->setCode($code);
            $entityManager->persist($fibu);
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
