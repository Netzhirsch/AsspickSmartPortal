<?php


namespace App\Controller;


use App\Entity\DamageCase\Car\Car;
use App\Entity\DamageCase\GeneralDamage\GeneralDamage;
use App\Entity\DamageCase\Liability;
use App\Entity\File;
use App\Repository\FileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FileController
 * @package App\Controller
 * @Route ("/file")
 */
class FileController extends AbstractController
{
    use ControllerTrait;

    /**
     * @Route("/{id}/{backTo}/{entityId}/download", name="file_download")
     * @param FileRepository $fileRepository
     * @param int $id
     * @param string $backTo
     * @param int $entityId
     * @return BinaryFileResponse|RedirectResponse
     */
    public function downloadAction(
        FileRepository $fileRepository,
        int $id,
        string $backTo,
        int $entityId
    )
    {
        $file = $fileRepository->find($id);
        $backTo = $this->getBackToUrl($backTo,$entityId);

        if (empty($file)) {
            $this->addFlash('error', 'Keine Datei mit der ID:'.$id.' gefunden.');
            return $this->redirect($backTo);
        }

        $filePath = $this->getFilePath($file);
        if (empty($filePath))
            return $this->redirect($backTo);

        $binaryFileResponse = new BinaryFileResponse($filePath);
        $binaryFileResponse->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $file->getName()
        );

        return $binaryFileResponse;
    }


    /**
     * @Route("/{id}/{backTo}/{entityId}/delete", name="file_delete")
     * @param FileRepository $fileRepository
     * @param int $id
     * @param string $backTo
     * @param int $entityId
     * @return BinaryFileResponse|RedirectResponse
     */
    public function deleteAction(
        FileRepository $fileRepository,
        int $id,
        string $backTo,
        int $entityId
    )
    {
        $file = $fileRepository->find($id);
        $backTo = $this->getBackToUrl($backTo,$entityId);

        $filePath = $this->getFilePath($file);
        if (empty($filePath))
            return $this->redirect($backTo);

        $em = $this->getDoctrine()->getManager();
        $em->remove($file);
        $em->flush();

        return $this->redirect($backTo);
    }

    private function getFilePath(File $file): string
    {

        $entity = $this->getPathInfos($file);
        if (empty($entity))
            return '';

        $filePath =
            $this->getUploadedIDr($entity->getCreatedAt(), $entity::UPLOAD_FOLDER)
            .DIRECTORY_SEPARATOR
            .$file->getName()
            .'.'
            .$file->getExtension()
        ;

        if (!file_exists($filePath)) {
            $this->addFlash('error', 'Datei konnte auf dem Server nicht gefunden werden. Datei:'.$filePath);
            return '';
        }

        return $filePath;
    }

    /**
     * @param File $file
     * @return Car|GeneralDamage|Liability|null
     */
    private function getPathInfos(File $file){

        $entity = $file->getLiability();
        if (empty($entity))
            $entity = $file->getCar();
        if (empty($entity))
            $entity = $file->getGeneralDamage();

        if (empty($entity)) {
            $this->addFlash('error', 'Datei konnte nicht zugeordnet werden.');
            return null;
        }

        return $entity;
    }

    private function getBackToUrl(string $backTo,?int $entityId): string
    {
        $backTo = explode(',', $backTo);
        if (empty($entityId))
            return $this->generateUrl($backTo[0]);
        return $this->generateUrl($backTo[1],['id' => $entityId]);
    }
}