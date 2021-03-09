<?php

namespace App\Controller\DownloadCenter;

use App\Entity\DownloadCenter\File;
use App\Repository\DownloadCenter\FileRepository;
use App\Repository\DownloadCenter\FolderRepository;
use DateTime;
use DateTimeInterface;
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

        $today = new DateTime();

        $newFiles = $fileRepository->findNew();
        foreach ($newFiles as $newFile) {
            $this->setFileIsNew($today,$newFile->getUpdatedAt(),$newFile);
        }


        foreach ($folders as $folder) {
            foreach ($folder->getFiles() as $file) {
                $this->setFileIsNew($today,$file->getUpdatedAt(),$file);
            }
            $children = $folder->getChildren();
            while($children->count() > 0) {
                foreach ($children as $child) {
                    foreach ($child->getFiles() as $childFile) {
                        $this->setFileIsNew($today,$childFile->getUpdatedAt(),$childFile);
                    }
                    $children = $child->getChildren();
                }
            }
        }

        return $this->render('download_center/user_view/index.html.twig',[
            'newFiles' => $newFiles,
            'folders' => $folders,
            'isChild' => !empty($id)
        ]);
    }

    private function setFileIsNew(DateTime $today, DateTimeInterface $updatedAt,File $file){
        if ($this->isUpdatedAWeekAgo($today, $updatedAt)) {
            $file->setIsNew(true);
        }
    }
    private function isUpdatedAWeekAgo(DateTime $today, DateTimeInterface $updatedAt): bool
    {
        $daysBetween = $today->diff($updatedAt)->days;
        return $daysBetween !== false && $today->diff($updatedAt)->days < 7;
    }
}
