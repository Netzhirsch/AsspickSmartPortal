<?php

namespace App\Controller\DownloadCenter;

use App\Controller\ControllerTrait;
use App\Entity\DownloadCenter\File;
use App\Entity\DownloadCenter\Folder;
use App\Form\DownloadCenter\FileType;
use App\Repository\DownloadCenter\FileRepository;
use App\Repository\DownloadCenter\FolderRepository;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/download/center/file")
 */
class FileController extends AbstractController
{
    use ControllerTrait;

    /**
     * @Route("/{folderId}", name="download_center_file_index", methods={"GET"})
     * @param FolderRepository $folderRepository
     * @param int $folderId
     * @return Response
     */
    public function indexAction(FolderRepository $folderRepository,int $folderId): Response
    {
        $folder = $folderRepository->find($folderId);
        if (empty($folder)) {
            $this->addFlash('error', 'Ein Ordner mit der Id:'.$folderId.' konnte nicht gefunden werden.');
            return $this->redirectToRoute('download_center_folder_index');
        }
        $files = $folder->getFiles();
        return $this->render('download_center/file/index.html.twig', [
            'files' => $files,
            'folderId' => $folderId
        ]);
    }

    /**
     * @Route("/new/{folderId}", name="download_center_file_new", methods={"GET","POST"})
     * @Route("/{id}/{folderId}/edit", name="download_center_file_edit", methods={"GET","POST"})
     * @param FileRepository $fileRepository
     * @param FolderRepository $folderRepository
     * @param Request $request
     * @param int $folderId
     * @param int|null $id
     * @return Response
     */
    public function formAction(
        FileRepository $fileRepository,
        FolderRepository $folderRepository,
        Request $request,
        int $folderId,
        int $id = null
    ): Response
    {
        $folder = $folderRepository->find($folderId);
        if (empty($id)) {
            $action = 'erstellen';
            $file = new File();
        } else {
            $action = 'bearbeiten';
            $file = $fileRepository->find($id);
            if (empty($file)) {
                $this->addFlashNotFound($id);
                return $this->redirectToRoute('download_center_file_index',['folderId' => $folderId]);
            }

            $path = $this->getDir($file->getFolder())
                .DIRECTORY_SEPARATOR
                .$file->getFileName();

            if (file_exists($path)) {
                $file->setPath($path);
                $file->setSize(filesize($path));
            }
        }
        $file->setFolder($folder);
        $form = $this->createForm(FileType::class, $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            if (empty($folder)) {
                $this->addFlash('error', 'Ein Ordner mit der Id:'.$folderId.' konnte nicht gefunden werden.');
                return $this->redirectToRoute('download_center_folder_index',['folderId' => $folderId]);
            }

            $error = $this->handleFiles($request, $folder, $entityManager,$file);
            if (empty($error)) {
                $file->setUpdatedAt((new DateTime()));
                $entityManager->persist($file);
                $entityManager->flush();

                return $this->redirectToRoute('download_center_file_index',['folderId' => $folderId]);
            }
            $this->addFlash('error', $error);
        }


        return $this->render('download_center/file/form.html.twig', [
            'action' => $action,
            'folderId' => $folderId,
            'file' => $file,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/filedrop/{uid}", name="download_center_file_drop")
     * @param Request $request
     * @param string|null $uid
     * @return JsonResponse
     */
    public function fileDropAction(Request $request,string $uid = null): JsonResponse
    {
        $files = $request->files->all();
        /** @var UploadedFile $file */
        if (empty($uid))
            $uid = uniqid();
        $tmpDir = \App\Controller\FileController::getTmp($uid);

        if (!file_exists($tmpDir))
            mkdir($tmpDir,0755,true);

        foreach ($files as $file) {
            $name = $file->getClientOriginalName();
            $uniqName = $this->getUniqName($tmpDir, $name);
            rename($file->getPathname(), $tmpDir.DIRECTORY_SEPARATOR.$uniqName);
        }

        return new JsonResponse(['uid' => $uid]);
    }

    /**
     * @Route("/{id}/{folderId}", name="download_center_file_delete", methods={"DELETE"})
     * @param FileRepository $fileRepository
     * @param Request $request
     * @param int $id
     * @param int $folderId
     * @return Response
     */
    public function deleteAction(FileRepository $fileRepository,Request $request, int $id, int $folderId): Response
    {
        $file = $fileRepository->find($id);
        if (empty($file)) {
            $this->addFlashNotFound($id);
            return $this->redirectToRoute('download_center_file_index',['folderId' => $folderId]);
        }

        if ($this->isCsrfTokenValid('delete'.$file->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($file);
            $entityManager->flush();
        } else {
            $this->addFlash('error', 'Sicherheitsüberprüfung fehlgeschlagen bitte erneut versuchen.');
        }

        return $this->redirectToRoute('download_center_file_index',['folderId' => $folderId]);
    }

    /**
     * @Route("/{id}/download", name="download_center_file_download")
     * @param FileRepository $fileRepository
     * @param int $id
     * @return BinaryFileResponse|RedirectResponse
     */
    public function downloadAction(
        FileRepository $fileRepository,
        int $id
    )
    {
        $file = $fileRepository->find($id);
        if (empty($file)) {
            $this->addFlash('error', 'Keine Datei mit der ID:'.$id.' gefunden.');
            return $this->redirectToRoute('download_center_user_view');
        }

        $dir = $this->getDir($file->getFolder());
        $filePath = $dir.DIRECTORY_SEPARATOR.$file->getFileName();
        if (!file_exists($filePath)) {
            $this->addFlash('error', 'Keine Datei im Pfad :'.$filePath.' gefunden.');
            return $this->redirectToRoute('download_center_user_view');
        }

        $binaryFileResponse = new BinaryFileResponse($filePath);
        $binaryFileResponse->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $file->getFileName()
        );

        return $binaryFileResponse;
    }

    private function addFlashNotFound($id){
        $this->addFlash('error', 'Eine Datei mit der Id: '.$id.' konnte nicht gefunden werden.');
    }

    /**
     * @param Request $request
     * @param Folder $folder
     * @param ObjectManager $em
     * @param File $file
     * @return string
     */
    private function handleFiles(Request $request,Folder $folder,ObjectManager $em,File $file): string
    {
        $data = $request->request->get('file');
        $error = $this->saveFile($data,$folder,$file);
        if (!empty($error))
            return $error;

        $removedFiles = $request->request->get('removed-file');
        $error = $this->removeFiles($removedFiles, $em, $folder);
        if (!empty($error))
            return $error;

        $em->persist($file);
        $em->flush();

        if (!file_exists($this->getDir($folder).DIRECTORY_SEPARATOR.$file->getFileName()))
            return 'Bitte laden Sie eine Datei hoch.';

        return $error;
    }

    private function saveFile(array $data,Folder $folder,File $file): string
    {

        if (!isset($data['tmpFolder']) || empty($data['tmpFolder']))
            return '';

        $tmpFolder = \App\Controller\FileController::getTmp($data['tmpFolder']);
        if (!file_exists($tmpFolder))
            return 'Bilder sind nicht mehr auf dem Server bitte erneut hochladen';

        $tmpFiles = scandir($tmpFolder);
        $error = '';
        foreach ($tmpFiles as $tmpFile) {
            if ($tmpFile != '.' && $tmpFile != '..') {
                $error .= $this->saveUploadedFile($tmpFolder,$tmpFile,$folder,$file);
            }
        }
        if (!rmdir($tmpFolder))
            return 'Tmp-Verzeichnis im folgenden Pfad konnte nicht gelöscht werden. '.$tmpFolder;

        return $error;
    }

    private function saveUploadedFile(
        string $tmpFolder,
        string $tmpFile,
        Folder $folder,
        File $fileEntity
    ): string
    {
        if (empty($tmpFile))
            return '';

        $dir = $this->getDir($folder);

        if (!file_exists($dir))
            mkdir($dir, 0755, true);

        try {
            $tmpFiles = scandir($tmpFolder);
            foreach ($tmpFiles as $file) {
                if ($file == '.' || $file == '..')
                    continue;
                rename($tmpFolder.DIRECTORY_SEPARATOR.$file, $dir.DIRECTORY_SEPARATOR.$file);
                $fileEntity->setFileName($file);
            }
        } catch (FileException $fileException) {
            return 'Datei konnte nicht gespeichert werden.';
        }

        return '';
    }

    /**
     * @param array|null $removedFiles
     * @param ObjectManager $em
     * @param Folder $folder
     * @return string
     */
    protected function removeFiles(
        ?array $removedFiles,
        ObjectManager $em,
        Folder $folder
    ): string
    {
        $dir = $this->getDir($folder);
        if (!empty($removedFiles)) {
            $repo = $em->getRepository(File::class);
            foreach ($removedFiles as $removedFile) {
                if (empty($removedFile)) {
                    continue;
                }
                $file = $repo->find($removedFile);
                $filePath = $dir.DIRECTORY_SEPARATOR.$file->getFileName();
                if (file_exists($filePath)) {
                    if (!unlink($filePath)) {
                        return 'Datei konnte nicht gelöscht werden. '.$dir;
                    }
                    $file->setFileName('');
                }
            }
        }
        if ($folder->getFiles()->count() == 0) {
            $files = scandir($dir);
            $isEmpty = true;
            foreach ($files as $folder) {
                if ($folder != '.' && $folder != '..') {
                    $isEmpty = false;
                }
            }
            if ($isEmpty && !rmdir($dir))
                return 'Verzeichnis im folgenden Pfad konnte nicht gelöscht werden. '.$dir;
        }

        return '';
    }

    /**
     * @param Folder|null $folder
     * @return string
     */
    public static function getDir(?Folder $folder): string
    {
        $dir = dirname(__DIR__, 3)
            .DIRECTORY_SEPARATOR
            .'assets'
            .DIRECTORY_SEPARATOR
            .'uploaded'
            .DIRECTORY_SEPARATOR
            .'download_center';

        $parents = [];
        while (!empty($folder)) {
            $parents[] = $folder->getName();
            $folder = $folder->getParent();
        }
        krsort($parents);
        $dir .= DIRECTORY_SEPARATOR.implode(DIRECTORY_SEPARATOR, $parents);

        return $dir;
    }
}
