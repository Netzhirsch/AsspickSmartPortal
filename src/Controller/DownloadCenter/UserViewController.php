<?php

namespace App\Controller\DownloadCenter;

use App\Controller\ControllerTrait;
use App\Entity\DownloadCenter\File;
use App\Entity\DownloadCenter\Folder;
use App\Filter\UserViewFilter;
use App\Form\Filter\UserViewFilterType;
use App\Repository\DownloadCenter\FileRepository;
use App\Repository\DownloadCenter\FolderRepository;
use DateTime;
use DateTimeInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/download/center/user")
 */
class UserViewController extends AbstractController {

    use ControllerTrait;

    /**
     * @Route("/view/{id}", name="download_center_user_view", methods={"GET"})
     * @param Request $request
     * @param FolderRepository $folderRepository
     * @param FileRepository $fileRepository
     * @param int|null $id
     *
     * @return Response
     */
    public function userViewAction(
        Request $request,
        FolderRepository $folderRepository,
        FileRepository $fileRepository,
        int $id = null
    ): Response
    {

        $filter = new UserViewFilter();

        $filterform = $this->createForm(
            UserViewFilterType::class,
            $filter,
            [
                'method' => 'GET',
            ]
        );

        $filterform->handleRequest($request);

        if (($filterform->isSubmitted() && $filterform->isValid()) || $filter instanceof UserViewFilter) {
            /** @var UserViewFilter $filter */
            $filter = $filterform->getData();
        } else {
            $filter = null;
        }

		$today = new DateTime();

		if (empty($id)) {
			$folders = $folderRepository->findParentsVisible($filter);
			$showNewFiles = true;
			$showBreadcrumbs = false;
			$breadcrumbs = [];
		} else {
			$folder = $folderRepository->find($id);
			$folders = [$folder];
			$showBreadcrumbs = !empty($folder->getParent());
			$showNewFiles = empty($folder->getParent());
			$breadcrumbs = $this->getBreadcrumbs($folder);
		}

		$newFiles = $fileRepository->findNew($filter);
		foreach ($newFiles as $newFile)
			$this->setFileIsNew($today, $newFile->getUpdatedAt(), $newFile);

        foreach ($folders as $folder) {
			foreach ($folder->getFiles() as $file) {
				$this->setFileIsNew($today, $file->getUpdatedAt(), $file);
                if (!empty($filter) && !empty($filter->getName())) {
                    if (strpos($file->getName(), $filter->getName()) === false && strpos($file->getFileName(), $filter->getName()) === false)
                        $folder->removeFile($file);
                }
			}
			$children = $folder->getChildren();
			while ($children->count() > 0) {
				foreach ($children as $child) {
					foreach ($child->getFiles() as $childFile) {
						$this->setFileIsNew($today, $childFile->getUpdatedAt(), $childFile);
                        if (!empty($filter) && !empty($filter->getName())) {
                            if (strpos($childFile->getName(), $filter->getName()) === false && strpos($childFile->getFileName(), $filter->getName()) === false) {
                                $child->removeFile($childFile);
                            }
                        }
					}
					$children = $child->getChildren();
				}
			}
		}

		return $this->render(
			'download_center/user_view/index.html.twig',
			[
				'filterform' => $filterform->createView(),
			    'showNewFiles'    => $showNewFiles,
				'newFiles'        => $newFiles,
				'showBreadcrumbs' => $showBreadcrumbs,
				'breadcrumbs'     => $breadcrumbs,
				'folders'         => $folders,
				'isChild'         => !empty($id),
			]
		);
	}

	private function setFileIsNew(DateTime $today, DateTimeInterface $updatedAt, File $file) {
		if ($this->isUpdatedAWeekAgo($today, $updatedAt)) {
			$file->setIsNew(true);
		}
	}

	private function isUpdatedAWeekAgo(DateTime $today, DateTimeInterface $updatedAt):bool {
		$daysBetween = $today->diff($updatedAt)->days;
		return $daysBetween !== false && $today->diff($updatedAt)->days < 7;
	}

	private function getBreadcrumbs(Folder $folder):array {
		do {
			$result[] = clone $folder;
			$folder = $folder->getParent();
		} while (!empty($folder));
		return array_reverse($result);
	}
}
