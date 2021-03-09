<?php

namespace App\Controller\DownloadCenter;

use App\Repository\DownloadCenter\FileRepository;
use App\Repository\DownloadCenter\FolderRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/download/center/user")
 */
class UserViewController extends AbstractController
{
    /**
     * @Route("/view/dummy", name="download_center_user_view_dummy", methods={"GET"})
     * @return Response
     */
    public function userViewDummyAction()
    {
        return $this->render('files/index.html.twig');
    }

    /**
     * @Route("/view/{id}", name="download_center_user_view", methods={"GET"})
     * @param FolderRepository $folderRepository
     * @param FileRepository $fileRepository
     * @param int|null $id
     * @return Response
     */
    public function userViewAction(FolderRepository $folderRepository,FileRepository $fileRepository,int $id = null)
    {
        if (empty($id))
            $folders = $folderRepository->findParentsVisible();
        else
            $folders = [$folderRepository->find($id)];

        $newFiles = $fileRepository->findNew();

        $today = new DateTime();

        foreach ($folders as $folder) {
            foreach ($folder->getFiles() as $file) {
                $daysBetween = $today->diff($file->getUpdatedAt())->days;
                if ($daysBetween !== false && $today->diff($file->getUpdatedAt())->days < 7) {
                    $file->setIsNew(true);
                }
            }
        }
        return $this->render('download_center/user_view/index.html.twig',[
            'newFiles' => $newFiles,
            'folders' => $folders,
            'isChild' => !empty($id)
        ]);
    }
}
