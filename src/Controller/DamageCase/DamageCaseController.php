<?php


namespace App\Controller\DamageCase;


use App\Controller\ControllerTrait;
use App\Entity\DamageCase\Car\Car;
use App\Entity\DamageCase\GeneralDamage\GeneralDamage;
use App\Entity\DamageCase\Liability;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * Class DamageCaseController
 * @package App\Controller
 * @Route ("/damageCase/liability")
 */
class DamageCaseController extends AbstractController
{
    use ControllerTrait;

    /**
     * @param null|Liability|Car|GeneralDamage $entity
     * @param int $id
     * @return Response
     */
    protected function lock(
        $entity,
        int $id
    ): Response
    {
        if (empty($entity)) {
            $this->addFlashNotFound($id);
            return $this->redirectToRoute($entity::FORM_ROUTES['index']);
        }
        $insured = $entity->getInsured();
        if (empty($insured)) {
            $this->addFlashNoInsured();
            return $this->redirectToRoute($entity::FORM_ROUTES['index']);
        }
        $insuredName = $insured->getInsured();
        if (empty($insured)) {
            $this->addFlashNoInsured();
            return $this->redirectToRoute($entity::FORM_ROUTES['index']);
        }
        $number = $insured->getInsuranceNumber();
        if (empty($number))
            $number = $insured->getDangerNumber();
        if (empty($number)) {
            $this->addFlash
            (
                'error',
                'Es muss eine Versicherungsschein- oder Schaden-Nummer eingetragen sein.'
            );
            return $this->redirectToRoute('damageCase_liability_index');
        }
        $pdfClass = $entity::PDF_CLASS;
        $pdf = new $pdfClass();
        $pdf->create($entity);

        $dir =
            dirname(__DIR__,3)
            .DIRECTORY_SEPARATOR
            .'assets'
            .DIRECTORY_SEPARATOR
            .'pdfs'
            .DIRECTORY_SEPARATOR
            .$entity::UPLOAD_FOLDER
            .DIRECTORY_SEPARATOR
            .$insuredName
            .DIRECTORY_SEPARATOR
            .$number
        ;
        if (!file_exists($dir))
            mkdir($dir, 0755, true);
        $filePath = $dir.DIRECTORY_SEPARATOR.$insuredName.'-'.$number.'.pdf';
//        $pdf->Output($filePath, 'F');
        $pdf->Output($filePath, 'D');
//        $entity->setIsLocked(true);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($entity);
        $entityManager->flush();

        return $this->redirectToRoute($entity::FORM_ROUTES['index']);
    }

    protected function addFlashNotFound(int $id){
        $this->addFlash(
            'error',
            'Haftpflicht Schadensanzeige mit der Id:'.$id.' nicht gefunden.'
        );
    }

    protected function addFlashNoInsured(){
        $this->addFlash('error', 'Es muss ein Versicherer eingetragen sein.');
    }
}