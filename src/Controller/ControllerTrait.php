<?php

namespace App\Controller;

use App\Entity\DamageCase\Car\Car;
use App\Entity\DamageCase\GeneralDamage\GeneralDamage;
use App\Entity\DamageCase\Liability;
use App\Entity\File;
use App\Entity\News;
use App\Struct\Email;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;
use ReflectionClass;
use Swift_Attachment;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;

trait ControllerTrait
{
	/**
	 * @param $request
	 *
	 * @return mixed|string
	 */
	private function getControllerName($request): string
    {
		$_controller = $request->attributes->get('_controller');
		/** @noinspection PhpUnusedLocalVariableInspection */
		[$class, $method] = explode('::', $_controller, 2);

		return $class;
	}

	/**
	 * @param Request $request
	 * @param string  $name
	 *
	 * @return int|mixed
	 */
	protected function getPageFromSession(Request $request, $name = 'page'): int
    {
		$class = $this->getControllerName($request);
		$session = $request->getSession();
		$page = $request->query->getInt('page');
		$nameInSession = $class . '.' . $name;

		// Wenn die Page in den Parameters steht, soll sie gesetzt werden.
		if (!empty($page)) {
			$session->set($nameInSession, $page);
		} elseif ($session->has($nameInSession)) {
			$page = $session->get($nameInSession);
		}
		return empty($page) ? 1 : $page;
	}

	/**
	 * @param Request $request
	 * @param string  $name
	 */
	protected function removePageFromSession(Request $request, $name = 'page') {
		$class = $this->getControllerName($request);
		if ($request->getSession()->has($class . '.' . $name)) {
			$request->getSession()->remove($class . '.' . $name);
		}
	}

	/**
	 * @param EntityManagerInterface $em
	 * @param Request                $request
	 * @param                        $className
	 * @param string                 $name
	 *
	 * @return Object
	 */
	protected function getObjectFromSession(EntityManagerInterface $em, Request $request, $className, $name = ""): object
    {
		$session = $request->getSession();
		$nameInSession = $className . "." . $name;

		if ($session->has($nameInSession) && $session->get($nameInSession) instanceof $className) {
			$object = $session->get($nameInSession);

			if (is_object($object)) {
				try {
					$class = new ReflectionClass($className);

					if (!empty($class)) {
						foreach ($class->getMethods() as $class_method) {
							if (substr($class_method->getName(), 0, 3) !== "get") {
								continue;
							}

							$subObject = $object->{$class_method->getName()}();


							if (is_object($subObject)) {
								if (get_class($subObject) == "Doctrine\Common\Collections\ArrayCollection") {
									/** @var ArrayCollection $subObject */
									foreach ($subObject as $key => $subObj) {
										$subClass = new ReflectionClass(get_class($subObj));
										if ($subClass->hasMethod('getId')) {
											$newObj = $em->find(get_class($subObj), $subObj->getId());
											$subObject->set($key, $newObj);
										}
									}

									$setterMethod = substr_replace($class_method->getName(), "set", 0, 3);
									$object->$setterMethod($subObject);
								} else {
									$subClass = new ReflectionClass(get_class($subObject));
									if ($subClass->hasMethod('getId')) {
										$databaseObject = $em->find(get_class($subObject), $subObject->getId());

										$setterMethod = substr_replace($class_method->getName(), "set", 0, 3);
										$object->$setterMethod($databaseObject);
									}
								}
							}
						}
					}
					if ($class->hasMethod('getId')) {
						$object = $em->find(get_class($object), $object->getId());
					}
				} catch (Exception $exception) {
				}
			}
		} else {
			$object = new $className();
		}
		return $object;
	}

	/**
	 * @param Request $request
	 * @param         $className
	 * @param         $object
	 * @param string  $name
	 */
	protected function setObjectInSession(Request $request, $className, $object, $name = "") {
		$session = $request->getSession();
		$nameInSession = $className . "." . $name;
		$session->set($nameInSession, $object);
	}

    protected function getUnfilledPdfDir(): string
    {
        return $this->getRootDir()
            .DIRECTORY_SEPARATOR
            .'pdfs'
            .DIRECTORY_SEPARATOR
            .'unfilled'
            ;
    }

    /**
     * @param Request $request
     * @param Liability|Car|GeneralDamage|news $entity
     * @param ObjectManager $em
     * @return string
     */
    protected function handlePhotos(Request $request,$entity,ObjectManager $em): string
    {
        $data = $request->request->get($entity::UPLOAD_FOLDER);
        $error = $this->savePhotos($data,$entity,$em);
        if (!empty($error))
            return $error;

        $removedFiles = $request->request->get('removed-file');
        $error = $this->removePhotos($removedFiles, $em, $entity);
        if (!empty($error))
            return $error;

        return $error;
    }

    private function savePhotos(array $data,$entity,ObjectManager $em): string
    {

        if (!isset($data['tmpFolder']) || empty($data['tmpFolder']))
            return '';

        $tmpFolder = FileController::getTmp($data['tmpFolder']);
        if (!file_exists($tmpFolder))
            return 'Bilder sind nicht mehr auf dem Server bitte erneut hochladen';

        $files = scandir($tmpFolder);
        $error = '';
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $error .= $this->saveUploadedFile($tmpFolder,$file,$entity,$em);
            }
        }
        if (!rmdir($tmpFolder))
            return 'Tmp-Verzeichnis im folgenden Pfad konnte nicht gelöscht werden. '.$tmpFolder;

        return $error;
    }

    /**
     * @param Liability|Car|GeneralDamage $entity
     * @return array
     */
    protected function getFiles($entity): array
    {
        $files = [];
        foreach ($entity->getFiles() as $file) {
            $filePath = $this->getUploadedDir($entity->getCreatedAt(), $entity::UPLOAD_FOLDER)
                .DIRECTORY_SEPARATOR
                .$file->getName()
            ;
            if (file_exists($filePath))
                $files[] = $file;
        }
        return $files;
    }

    /**
     * @param string $tmpDir
     * @param string $file
     * @param Liability|Car|GeneralDamage|News $entity
     * @param ObjectManager $em
     * @return string
     */
    private function saveUploadedFile(string $tmpDir,string $file,$entity,ObjectManager $em): string
    {

	    if (empty($file))
            return '';
        $date = $entity->getCreatedAt();
        $dir = $this->getUploadedDir(($date), $entity::UPLOAD_FOLDER);
        $tmpFilePath = $tmpDir.DIRECTORY_SEPARATOR.$file;
        if (!file_exists($tmpDir))
            mkdir($tmpDir, 0755, true);
        try {
            rename($tmpFilePath, $dir.DIRECTORY_SEPARATOR.$file);
        } catch (FileException $fileException) {
            return 'Datei konnte nicht gespeichert werden.';
        }
        $newFile = new File();
        $newFile->setUploadAt((new DateTime()));
        $newFile->setName($file);
        if (method_exists($entity, 'addFile'))
            $entity->addFile($newFile);
        $em->persist($newFile);

        return '';
    }

    /**
     * @param array|null $removedFiles
     * @param ObjectManager $em
     * @param Liability|Car|GeneralDamage $entity
     * @return string
     */
    protected function removePhotos(
        ?array $removedFiles,
        ObjectManager $em,
        $entity
    ): string
    {
        if (!empty($removedFiles)) {
            $repo = $em->getRepository(File::class);
            foreach ($removedFiles as $removedFile) {
                if (empty($removedFile)) {
                    continue;
                }
                $file = $repo->find($removedFile);
                $path = $this->getFilePath($entity, $file);
                if (file_exists($path)) {
                    if (!unlink($path)) {
                        return 'Datei konnte nicht gelöscht werden. '.$path;
                    }
                }
                $em->remove($file);
                $em->flush();
            }
        }
        if ($entity->getFiles()->count() == 0) {
            $uploadedDir = $this->getUploadedDir($entity->getCreatedAt(),$entity::UPLOAD_FOLDER);
            $files = scandir($uploadedDir);
            $isEmpty = true;
            foreach ($files as $file) {
                if ($file != '.' && $file != '..') {
                    $isEmpty = false;
                }
            }
            if ($isEmpty && !rmdir($uploadedDir))
                return 'Verzeichnis im folgenden Pfad konnte nicht gelöscht werden. '.$uploadedDir;
        }

        return '';
    }

    private function sendMail(
        Swift_Mailer $mailer,
        Email $email
    ): int
    {
        $swiftMessage = $this->createMessage($email);

        return $mailer->send($swiftMessage);
    }

    private function sendMailWithAttachment(
        Swift_Mailer $mailer,
        Email $email,
        string $filePath
    ): int
    {
        $swiftMessage = $this->createMessage($email);

        $swiftMessage->attach(Swift_Attachment::fromPath($filePath));

        return $mailer->send($swiftMessage);
    }

    private function createMessage(
        Email $email
    ): Swift_Message
    {

        $body = $this->renderView(
            'mail/index.html.twig', ['email' => $email]
        );

        $message = (new Swift_Message($email->getSubject()))
            ->setFrom($email->getFrom())
            ->setBody($body, 'text/html');

        $message->setTo([$email->getTo()]);

        return $message;
    }

    /**
     * @param Collection|array $files
     * @param Liability|Car|GeneralDamage $entity
     */
    protected function setFileThumbnailData(
        $files,
        $entity
    ): void
    {
        foreach ($files as $file) {
            $pathThumbnail = $this->getThumbnailPath($entity, $file);
            $path = $this->getFilePath($entity,$file);
            if (file_exists($path)) {
                $file->setPath($pathThumbnail);
                $size = filesize($path);
                $file->setSize($size);
            }

        }
    }

    private function getRootDir(): string {
        return dirname(__DIR__,2)
            .DIRECTORY_SEPARATOR
            .'assets'
            ;
    }

    protected function getUploadedDir(DateTimeInterface $date,string $uploadFolder): string
    {
        $dir =  $this->getRootDir()
            .DIRECTORY_SEPARATOR
            .'uploaded'
            .DIRECTORY_SEPARATOR
            .$uploadFolder
            .DIRECTORY_SEPARATOR
            .$date->format('Y-m-d')
        ;
        if (!file_exists($dir))
            mkdir($dir, 0755, true);

        return $dir;
    }

    /**
     * @param string $dir
     * @param string $name
     * @return array|string
     */
    public static function getUniqName(
        string $dir,
        string $name
    )
    {

        $filesInDir = scandir($dir);
        $nameIndex = 0;
        foreach ($filesInDir as $fileInDir) {
            if ($fileInDir != "." && $fileInDir != "..") {
                $nameIndex++;
            }
        }
        if (!empty($nameIndex)) {
            $name = $nameIndex.'-'.$name;
        }

        return $name;
    }

    /**
     * @param Liability|Car|GeneralDamage $entity
     * @param File $file
     * @return string
     */
    private function getFilePath($entity,File $file): string
    {
        return $this->getUploadedDir($entity->getCreatedAt(),$entity::UPLOAD_FOLDER)
            .DIRECTORY_SEPARATOR.$file->getName()
        ;
    }

    /**
     * @param Liability|Car|GeneralDamage $entity
     * @param File $file
     * @return string
     */
    private function getThumbnailPath($entity,File $file): string
    {
        return $entity::UPLOAD_FOLDER
        .DIRECTORY_SEPARATOR
        .$entity->getCreatedAt()->format('Y-m-d')
        .DIRECTORY_SEPARATOR
        .$file->getName();
    }


}
