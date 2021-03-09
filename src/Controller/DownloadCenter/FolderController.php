<?php

namespace App\Controller\DownloadCenter;

use App\Entity\DownloadCenter\Folder;
use App\Form\DownloadCenter\FolderType;
use App\Repository\DownloadCenter\FolderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/download/center/folder")
 */
class FolderController extends AbstractController
{
    /**
     * @Route("/", name="download_center_folder_index", methods={"GET"})
     * @param FolderRepository $folderRepository
     * @return Response
     */
    public function indexAction(FolderRepository $folderRepository): Response
    {
        $folders = $folderRepository->findParents();
        $maxLevel = 0;

        foreach ($folders as $folder) {
            $children = $folder->getChildren();
            while ($children->count() > 0) {
                foreach ($children as $child) {
                    $maxLevel++;
                    $children = $child->getChildren();
                }
            }
        }

        return $this->render('download_center/folder/index.html.twig', [
            'folders' => $folders,
            'maxLevel' => $maxLevel
        ]);
    }

    /**
     * @Route("/new", name="download_center_folder_new", methods={"GET","POST"})
     * @Route("/{id}/edit", name="download_center_folder_edit", methods={"GET","POST"})
     * @param FolderRepository $folderRepository
     * @param Request $request
     * @param int|null $id
     * @return Response
     */
    public function formAction(FolderRepository $folderRepository,Request $request,int $id = null): Response
    {
        $oldFolder = null;
        if (empty($id)) {
            $action = 'erstellen';
            $folder = new Folder();
        } else {
            $action = 'bearbeiten';
            $folder = $folderRepository->find($id);
            if (empty($folder)) {
                $this->addFlashNotFound($id);
                return $this->redirectToRoute('download_center_folder_index');
            }
            $oldFolder = clone $folder;
        }


        $form = $this->createForm(FolderType::class, $folder);
        $form->handleRequest($request);

        $this->renameUploadDir($oldFolder,$folder);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($folder);
            $entityManager->flush();

            return $this->redirectToRoute('download_center_folder_index');
        }

        return $this->render('download_center/folder/form.html.twig', [
            'action' => $action,
            'folder' => $folder,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="download_center_folder_delete", methods={"DELETE"})
     * @param Request $request
     * @param FolderRepository $folderRepository
     * @param int $id
     * @return Response
     */
    public function deleteAction(Request $request, FolderRepository $folderRepository,int $id): Response
    {
        $folder = $folderRepository->find($id);
        if (empty($folder)) {
            $this->addFlashNotFound($id);
            return $this->redirectToRoute('download_center_folder_index');
        }

        if ($this->isCsrfTokenValid('delete'.$folder->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($folder);
            $entityManager->flush();
        } else {
            $this->addFlash('error', 'Sicherheitsüberprüfung fehlgeschlagen bitte erneut versuchen.');
        }

        return $this->redirectToRoute('download_center_folder_index');
    }

    private function addFlashNotFound($id){
        $this->addFlash('error', 'Ein Ordner mit der Id:'.$id.' konnte nicht gefunden werden.');
    }

    private function renameUploadDir(
        ?Folder $oldFolder,
        Folder $newFolder
    )
    {
        if (empty($oldFolder))
            return;

        $oldDir = FileController::getDir($oldFolder);
        $newDir = FileController::getDir($newFolder);
        if ($oldDir !== $newDir && file_exists($oldDir))
            rename($oldDir,$newDir);
    }
}
