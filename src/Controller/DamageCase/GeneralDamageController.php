<?php


namespace App\Controller\DamageCase;


use App\Controller\ControllerTrait;
use App\Entity\DamageCase\GeneralDamage\GeneralDamage;
use App\Form\DamageCase\GeneralDamage\GeneralDamageType;
use App\Repository\DamageCase\GeneralDamage\GeneralDamageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
/**
 * Class DamageCaseController
 * @package App\Controller
 * @Route ("/damageCase/generalDamage")
 */
class GeneralDamageController extends AbstractController
{
    use ControllerTrait;
    /**
     * @Route("/", name="damageCase_generalDamage_index")
     * @param GeneralDamageRepository $generalDamageRepository
     * @return Response
     */
    public function indexAction(GeneralDamageRepository $generalDamageRepository):Response
    {
        return $this->render('damage_case/general_damage/index.html.twig',['generalDamage' => $generalDamageRepository->findAll()]);
    }

    /**
     * @Route("/new", name="damageCase_generalDamage_new")
     * @Route("/{id}/edit", name="damageCase_generalDamage_edit")
     * @param GeneralDamageRepository $generalDamageRepository
     * @param Request $request
     * @param int|null $id
     * @return Response
     */
    public function formAction(
        GeneralDamageRepository $generalDamageRepository,
        Request $request,
        int $id = null
    ): Response
    {
        if (empty($id)) {
            $action = "erstellen";
            $generalDamage = new GeneralDamage();
        } else {
            $generalDamage = $generalDamageRepository->find($id);
            $action = "bearbeiten";
        }

        $form = $this->createForm(GeneralDamageType::class,$generalDamage);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $error = $this->handlePhotos($request,$generalDamage,$em);
            if (!empty($error)) {
                $this->addFlash('error', $error);
            } else {
                $em->persist($generalDamage);
                $em->flush();
                $this->addFlash('success', 'Formular wurde erfolgreich gespeichert.');
            }
            return $this->redirectToRoute('damageCase_generalDamage_index');
        }

        $this->setFileThumbnailData($generalDamage->getFiles(), $generalDamage);

        $parameters = [
            'form'       => $form->createView(),
            'action'     => $action,
            'generalDamage' => $generalDamage
        ];

        return $this->render('damage_case/general_damage/form.html.twig', $parameters);
    }

    /**
     * @Route("/download", name="damageCase_generalDamage_download")
     * @return BinaryFileResponse|JsonResponse
     */
    public function downloadAction()
    {
        $filename = 'Schadenanzeige_SACH';
        $filePath = $this->getUnfilledPdfDir().DIRECTORY_SEPARATOR.$filename.'.pdf';

        if (!file_exists($filePath)) {
            return new JsonResponse();
        }
        $binaryFileResponse = new BinaryFileResponse($filePath);
        $binaryFileResponse->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $filename
        );

        return $binaryFileResponse;
    }

    /**
     * @Route("/{id}", name="damageCase_generalDamage_delete", methods={"DELETE"})
     * @param Request             $request
     * @param GeneralDamageRepository $generalDamageRepository
     * @param int                 $id
     *
     * @return Response
     */
    public function deleteAction(
        Request $request,
        GeneralDamageRepository $generalDamageRepository,
        int $id
    ): Response {

        $generalDamage = $generalDamageRepository->find($id);
        if (empty($generalDamage)) {
            $this->addFlash(
                'error',
                'Haftpflicht Schadensanzeige mit der ID '.$id.' nicht gefunden.'
            );

            return $this->redirectToRoute('damageCase_generalDamage_index');
        } elseif ($this->isCsrfTokenValid('delete' . $generalDamage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($generalDamage);
            $entityManager->flush();
            $this->addFlash('success', 'Haftpflicht Schadensanzeige gelöscht');
        } else {
            $this->addFlash('error', 'Sicherheitsüberprüfung ist fehlgeschlagen bitte Sie es erneut.');
        }

        return $this->redirectToRoute('damageCase_generalDamage_index');
    }

}
