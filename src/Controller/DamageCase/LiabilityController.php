<?php


namespace App\Controller\DamageCase;


use App\Controller\ControllerTrait;
use App\Entity\DamageCase\Liability;
use App\Form\DamageCase\LiabilityType;
use App\Repository\DamageCase\LiabilityRepository;
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
 * @Route ("/damageCase/liability")
 */
class LiabilityController extends AbstractController
{
    use ControllerTrait;

    /**
     * @Route("/", name="damageCase_liability_index")
     * @param LiabilityRepository $liabilityRepository
     * @return Response
     */
    public function indexAction(LiabilityRepository $liabilityRepository):Response
    {
        return $this->render('damage_case/liability/index.html.twig',['liabilities' => $liabilityRepository->findAll()]);
    }

    /**
     * @Route("/new", name="damageCase_liability_new")
     * @Route("/{id}/edit", name="damageCase_liability_edit")
     * @param LiabilityRepository $liabilityRepository
     * @param Request $request
     * @param int|null $id
     * @return Response
     */
    public function formAction(LiabilityRepository $liabilityRepository,Request $request,int $id = null):Response
    {
        if (empty($id)) {
            $action = "erstellen";
            $liability = new Liability();
        } else {
            $liability = $liabilityRepository->find($id);
            $action = "bearbeiten";

        }

        $form = $this->createForm(LiabilityType::class,$liability);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($liability);
            $em->flush();
            return $this->redirectToRoute('damageCase_liability_index');
        }

        $parameters = [
            'form'       => $form->createView(),
            'action'     => $action,
        ];

        return $this->render('damage_case/liability/form.html.twig', $parameters);
    }

    /**
     * @Route("/download", name="damageCase_liability_download")
     * @return BinaryFileResponse|JsonResponse
     */
    public function downloadAction()
    {
        $filename = 'Schadenanzeige_HAFTPFLICHT';
        $filePath = $this->getDir().DIRECTORY_SEPARATOR.$filename.'.pdf';

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
     * @Route("/{id}", name="damageCase_liability_delete", methods={"DELETE"})
     * @param Request             $request
     * @param LiabilityRepository $liabilityRepository
     * @param int                 $id
     *
     * @return Response
     */
    public function deleteAction(
        Request $request,
        LiabilityRepository $liabilityRepository,
        int $id
    ): Response {

        $liability = $liabilityRepository->find($id);
        if (empty($liability)) {
            $this->addFlash(
                'error',
                'Haftpflicht Schadensanzeige mit der Id:'.$id.' nicht gefunden.'
            );

            return $this->redirectToRoute('damageCase_liability_index');
        } elseif ($this->isCsrfTokenValid('delete' . $liability->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($liability);
            $entityManager->flush();
            $this->addFlash('success', 'Haftpflicht Schadensanzeige gelöscht');
        } else {
            $this->addFlash('error', 'Sicherheitsüberprüfung fehlgeschlagen bitte nochmal versuchen.');
        }

        return $this->redirectToRoute('damageCase_liability_index');
    }

}