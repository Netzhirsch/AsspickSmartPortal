<?php

namespace App\Controller;

use App\Entity\ActivationCode;
use App\Entity\File;
use App\Form\ActivationCodeFileType;
use App\Form\ActivationCodeType;
use App\Repository\ActivationCodeRepository;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/activation_code")
 */
class ActivationCodeController extends AbstractController
{
    /**
     * @Route("/", name="activation_code_index", methods={"GET","POST"})
     * @param Request $request
     * @param ActivationCodeRepository $activationCodeRepository
     * @return Response
     */
    public function indexAction(
        Request $request,
        ActivationCodeRepository $activationCodeRepository
    ): Response
    {
        $file = new File();
        $file->setUploadAt((new DateTime()));
        $form = $this->createForm(ActivationCodeFileType::class, $file);
        $form->handleRequest($request);
        $activationCodes = $activationCodeRepository->findBy([], ['email' => 'ASC']);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            if (isset($form['file'])) {
                $this->readCsv($form, $activationCodes, $entityManager);
            }

            return $this->redirectToRoute('activation_code_index');
        }

        return $this->render(
            'activation_code/index.html.twig',
            [
                'activation_codes' => $activationCodes,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/new", name="activation_code_new", methods={"GET","POST"})
     * @Route("/{id}/edit", name="activation_code_edit", methods={"GET","POST"})
     * @param Request $request
     * @param ActivationCodeRepository $activationCodeRepository
     * @param int|null $id
     * @return Response
     */
    public function formAction(
        Request $request,
        ActivationCodeRepository $activationCodeRepository,
        int $id = null
    ): Response
    {
        if (empty($id)) {
            $action = 'erstellen';
            $activationCode = new ActivationCode();
        } else {
            $action = 'bearbeiten';
            $activationCode = $activationCodeRepository->find($id);
            if (empty($activationCode)) {
                $this->notFoundFlash($id);
                $this->redirectToRoute('activation_code_index');
            }

        }
        $form = $this->createForm(ActivationCodeType::class, $activationCode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($activationCode);
            $entityManager->flush();

            return $this->redirectToRoute('activation_code_index');
        }

        return $this->render(
            'activation_code/form.html.twig',
            [
                'action' => $action,
                'activation_code' => $activationCode,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="activation_code_delete", methods={"DELETE"})
     * @param Request $request
     * @param ActivationCodeRepository $activationCodeRepository
     * @param int $id
     * @return Response
     */
    public function deleteAction(
        Request $request,
        ActivationCodeRepository $activationCodeRepository,
        int $id
    ): Response
    {
        $activationCode = $activationCodeRepository->find($id);
        if (empty($activationCode)) {
            $this->notFoundFlash($id);
        } elseif ($this->isCsrfTokenValid('delete'.$activationCode->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($activationCode);
            $entityManager->flush();
        } else {
            $this->addFlash
            (
                'error',
                'Sicherheitsüberprüfung fehlgeschlagen bitte versuchen Sie es erneut.'
            );
        }

        return $this->redirectToRoute('activation_code_index');
    }

    private function notFoundFlash($id)
    {
        $this->addFlash('error', 'Aktivierungscode mit der Id:'.$id.' konnte nicht gefunden werden.');
    }

    /**
     * @param FormInterface $form
     * @param ActivationCode[] $activationCodes
     * @param ObjectManager $entityManager
     */
    private function readCsv(
        FormInterface $form,
        array $activationCodes,
        ObjectManager $entityManager
    ): void
    {
        /** @var UploadedFile $file */
        $file = $form['file']->getData();
        if (!$this->isCsv($file)) {
            $this->addFlash('error', 'Bitte nur CSV Dateien hochladen.');
            return;
        }

        $path = $file->getPathname();
        if (!file_exists($path))
            return;

        $file_handle = fopen($path, "r");
        if ($file_handle) {
            $lineNumber = 0;
            while (($line = fgetcsv($file_handle, 3000, ";")) !== false) {

                $lineNumber++;
                if ($this->noInfoInLine($lineNumber,$line))
                    continue;

                $email = $line[0];
                $email = strtolower($email);
                $code = $line[1];

                foreach ($activationCodes as $activationCode) {
                    if ($activationCode->getEmail() == $email) {
                        $activationCode->setCode($code);
                        continue 2;
                    }
                }

                $activationCode = new ActivationCode();
                $activationCode->setEmail($email);
                $activationCode->setCode($code);
                $entityManager->persist($activationCode);
            }
        }

        $entityManager->flush();
    }

    private function isCsv(UploadedFile $file): bool
    {
        $mineType = $file->getMimeType();

        return $mineType == 'text/csv' || $mineType == 'text/plain';
    }

    private function noInfoInLine(
        int $lineNumber,
        array $line
    ): bool
    {
        return $lineNumber == 1
            || empty($line)
            || !isset($line[0])
            || !isset($line[1])
            || empty($line[0])
            || empty($line[1]);
    }
}
