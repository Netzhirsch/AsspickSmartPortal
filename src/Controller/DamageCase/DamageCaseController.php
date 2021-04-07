<?php


namespace App\Controller\DamageCase;


use App\Controller\ControllerTrait;
use App\Entity\DamageCase\Car\Car;
use App\Entity\DamageCase\GeneralDamage\GeneralDamage;
use App\Entity\DamageCase\Liability;
use App\Struct\Email;
use Swift_Mailer;
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

    private Swift_Mailer $mailer;
    
    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

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

        $insurer = $entity->getInsurer();
        if (empty($insurer)) {
            $this->addFlashNoInsured();
            return $this->redirectToRoute($entity::FORM_ROUTES['index']);
        }

        $number = $insurer->getInsuranceNumber();
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

        $insuredName = $insurer->getName();
        $dir = $this->makeDir($entity::UPLOAD_FOLDER, $insuredName);
        $filePath = $dir.DIRECTORY_SEPARATOR.$insuredName.'-'.$number.'.pdf';
        $pdf->Output($filePath, 'F');
        $this->sendNotificationMail($entity,$filePath);

        $entity->setIsLocked(true);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($entity);
        $entityManager->flush();

        return $this->redirectToRoute($entity::FORM_ROUTES['index']);
    }

    /**
     * @param Liability|Car|GeneralDamage $entity
     * @param string $filePath
     */
    private function sendNotificationMail($entity,string $filePath){

        $email = new Email();
        $email->setFrom('asspick@asspick.de');
        $email->setTo('schaden@netzhirsch.de');
        $email->setSubject('Schadensformular wurde eingereicht');

        $policyholder = $entity->getPolicyholder();
        $insurer = $entity->getInsurer();

        $email->setMessage(
            'Der Versicherer'
            .' '
            .$insurer->getName()
            .' '
            .'hat ein Schadensformular für den Versicherungsnehmer'
            .' '
            .$policyholder->__toString()
            .' '
            .'mit der Versicherungsnummer'
            .' '
            .$insurer->getInsuranceNumber()
            .' '
            .'eingereicht.'
        );

        $countReceiver = $this->sendMailWithAttachment($this->mailer, $email,$filePath);

        if
        (
            $countReceiver != 1
        ) {
            $this->addFlash
            (
                'error'
                ,
                'Es konnte leider keine E-Mail versandt werden, 
                    bitte melden Sie sich direkt bei asspick@asspick.de'
            );
        }
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

    /**
     * @param string $uploadFolder
     * @param string|null $insuredName
     * @return string
     */
    protected function makeDir(
        string $uploadFolder,
        ?string $insuredName
    ): string
    {
        $dir = $this->getDir($uploadFolder, $insuredName);

        if (!file_exists($dir))
            mkdir($dir, 0755, true);

        return $dir;
    }

    /**
     * @param string $uploadFolder
     * @param string|null $insuredName
     * @return string
     */
    protected function getDir(
        string $uploadFolder,
        ?string $insuredName
    ): string
    {
        return dirname(__DIR__, 3)
        .DIRECTORY_SEPARATOR
        .'assets'
        .DIRECTORY_SEPARATOR
        .'pdfs'
        .DIRECTORY_SEPARATOR
        .$uploadFolder
        .DIRECTORY_SEPARATOR
        .$insuredName
        ;
    }


}