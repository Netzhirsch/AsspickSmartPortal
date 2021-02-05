<?php

namespace App\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use ReflectionClass;
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

	protected function getDir(): string
    {
        return dirname(__DIR__,2).DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'pdfs';
    }
}