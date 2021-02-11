<?php

namespace App\Controller;

use App\Entity\DamageCase\Car\Car;
use App\Entity\DamageCase\GeneralDamage\GeneralDamage;
use App\Entity\DamageCase\Liability;
use App\Entity\File;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;
use ReflectionClass;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
     * @param $files
     * @param Liability|Car|GeneralDamage $entity
     * @param ObjectManager $em
     * @return string
     */
    protected function saveUploadedPhotos($files,$entity,ObjectManager $em): string
    {
        if (empty($files))
            return '';
        $error = '';
        if (!is_array($files))
            $files = [$files];
        /** @var UploadedFile $file */
        foreach ($files as $file) {
            if (strpos($file->getMimeType(), 'image') !== false)
                $error .= $this->saveUploadedFile($file, $entity, $em);
            else
                $error = 'Bitte nur Bilder hochladen.';
        }
        return $error;
    }

    /**
     * @param $files
     * @param Liability|Car|GeneralDamage $entity
     * @param ObjectManager $em
     * @return string
     */
    protected function saveUploadedFiles($files,$entity,ObjectManager $em): string
    {
        if (empty($files))
            return '';
        $error = '';
        if (is_array($files)) {
            foreach ($files as $file) {
                $error .= $this->saveUploadedFile($file, $entity, $em);
            }
        } else {
            $file = $files;
            $error .= $this->saveUploadedFile($file, $entity, $em);
        }
        return $error;
    }

    protected function getUploadedIDr(DateTimeInterface $date,string $uploadFolder): string
    {
        return $this->getRootDir()
            .DIRECTORY_SEPARATOR
            .'uploaded'
            .DIRECTORY_SEPARATOR
            .$uploadFolder
            .DIRECTORY_SEPARATOR
            .$date->format('Y-m-d')
            ;
    }

    /**
     * @param Liability|Car|GeneralDamage $entity
     * @return array
     */
    protected function getFiles($entity): array
    {
        $files = [];
        foreach ($entity->getFiles() as $file) {
            $filePath = $this->getUploadedIDr($entity->getCreatedAt(), $entity::UPLOAD_FOLDER)
                .DIRECTORY_SEPARATOR
                .$file->getName()
                .'.'
                .$file->getExtension()
            ;
            if (file_exists($filePath))
                $files[] = $file;
        }
        return $files;
    }

    /**
     * @param UploadedFile|null $file
     * @param Liability|Car|GeneralDamage $entity
     * @param ObjectManager $em
     * @return string
     */
    private function saveUploadedFile(?UploadedFile $file,$entity,ObjectManager $em): string
    {

	    if (empty($file))
            return '';
        $date = $entity->getCreatedAt();
        $dir = $this->getUploadedIDr(($date), $entity::UPLOAD_FOLDER);
        if (!file_exists($dir))
            mkdir($dir, 0755, true);
        $name = $file->getClientOriginalName();
        $extension = $file->guessClientExtension();
        $name = $this->getFileWithoutExtension($extension,$name);
        $nameIndex = 0;
        $filesInDir = scandir($dir);
        foreach($filesInDir as $fileInDir) {
            if  ($fileInDir != "." && $fileInDir != "..") {
                $nameIndex++;
            }
        }
        if (!empty($nameIndex))
            $name = $nameIndex.'-'.$name;
        try {
            $file->move($dir, $name.'.'.$extension);
        } catch (FileException $fileException) {
            return 'Datei konnte nicht gespeichert werden.';
        }
        $newFile = new File();
        $newFile->setUploadAt((new DateTime()));
        $newFile->setName($name);
        $newFile->setSize($file->getSize());
        $newFile->setExtension($extension);
        $entity->addFile($newFile);
        $em->persist($newFile);

        return '';
    }

    private function getFileWithoutExtension($extension,$name){
        $extension = '.'.$extension;
        $name = str_replace($extension, '', $name);
        return str_replace(strtoupper($extension), '', $name);
    }

    private function getRootDir(): string {
        return dirname(__DIR__,2)
            .DIRECTORY_SEPARATOR
            .'assets'
            ;
    }


}