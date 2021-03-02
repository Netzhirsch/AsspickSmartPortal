<?php


namespace App\Controller\DamageCase;


use App\Controller\ControllerTrait;
use App\Entity\DamageCase\Car\Car;
use App\Form\DamageCase\Car\CarType;
use App\Repository\DamageCase\Car\CarRepository;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
/**
 * Class DamageCaseController
 * @package App\Controller
 * @Route ("/damageCase/car")
 */
class CarController extends DamageCaseController
{
    use ControllerTrait;

    /**
     * @Route("/", name="damageCase_car_index")
     * @param CarRepository $carRepository
     * @return Response
     */
    public function indexAction(CarRepository $carRepository):Response
    {
        return $this->render('damage_case/car/index.html.twig',['car' => $carRepository->findAll()]);
    }

    /**
     * @Route("/new", name="damageCase_car_new")
     * @Route("/{id}/edit", name="damageCase_car_edit")
     * @param CarRepository $carRepository
     * @param Request $request
     * @param int|null $id
     * @return Response
     */
    public function formAction(
        CarRepository $carRepository,
        Request $request,
        int $id = null
    ): Response
    {
        if (empty($id)) {
            $action = "erstellen";
            $car = new Car();
        } else {
            $car = $carRepository->find($id);
            $action = "bearbeiten";

        }

        $form = $this->createForm(CarType::class,$car);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $error = $this->handlePhotos($request,$car,$em);
            if (!empty($error)) {
                $this->addFlash('error', $error);
            } else {
                $em->persist($car);
                $em->flush();
                $this->addFlash('success', 'Formular wurde erfolgreich gespeichert.');
            }
            return $this->redirectToRoute('damageCase_car_index');
        }

        $this->setFileThumbnailData($car->getFiles(), $car);

        $parameters = [
            'form'       => $form->createView(),
            'action'     => $action,
            'car' => $car
        ];

        return $this->render('damage_case/car/form.html.twig', $parameters);
    }

    /**
     * @Route("/download", name="damageCase_car_download")
     * @return BinaryFileResponse|JsonResponse
     */
    public function downloadAction()
    {
        $filename = 'Schadenanzeige_KFZ';
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
     * @Route("/{id}", name="damageCase_car_delete", methods={"DELETE"})
     * @param Request             $request
     * @param CarRepository $carRepository
     * @param int                 $id
     *
     * @return Response
     */
    public function deleteAction(
        Request $request,
        CarRepository $carRepository,
        int $id
    ): Response {

        $car = $carRepository->find($id);
        if (empty($car)) {
            $this->addFlash(
                'error',
                'Haftpflicht Schadensanzeige mit der Id:'.$id.' nicht gefunden.'
            );

            return $this->redirectToRoute('damageCase_car_index');
        } elseif ($this->isCsrfTokenValid('delete' . $car->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($car);
            $entityManager->flush();
            $this->addFlash('success', 'Haftpflicht Schadensanzeige gelöscht');
        } else {
            $this->addFlash('error', 'Sicherheitsüberprüfung fehlgeschlagen bitte nochmal versuchen.');
        }

        return $this->redirectToRoute('damageCase_car_index');
    }

    /**
     * @Route("/{id}", name="damageCase_car_lock", methods={"GET"})
     * @param CarRepository $carRepository
     * @param int $id
     * @return Response
     */
    public function lockAction(
        CarRepository $carRepository,
        int $id
    ): Response
    {
        $car = $carRepository->find($id);
        return $this->lock($car,$id);
    }
}