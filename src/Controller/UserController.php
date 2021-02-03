<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user")
 * @Security("is_granted('ROLE_ADMIN')")
 */
class UserController extends AbstractController
{
    use ControllerTrait;

    /**
     * @Route("/", name="user_index", methods={"GET"})
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @param UserRepository $userRepository
     * @return Response
     */
    public function indexAction
    (
        PaginatorInterface $paginator,
        Request $request,
        UserRepository $userRepository
    ): Response
    {
        $page = $this->getPageFromSession($request);
        $pageLimit = $this->getParameter('index_limit');
        $users = $paginator->paginate(
            $userRepository->findAll(),
            $page,
            $pageLimit
        );

        // Wenn auf der aktuellen Seite keine Einträge gefunden werden auf die erste Seite leiten
        if (empty($users->count()) && $page > 1) {
            $this->removePageFromSession($request);
            return $this->redirectToRoute('user_index', ['page' => 1]);
        }

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     * @Route("/new", name="user_new", methods={"GET","POST"})
     * @param Request $request
     * @param UserRepository $userRepository
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param int|null $id
     * @return Response
     */
    public function formAction(
        Request $request,
        UserRepository $userRepository,
        UserPasswordEncoderInterface $passwordEncoder,
        int $id = null
    ): Response
    {
        if (empty($id)) {
            $user = new User();
            $action = "erstellen";
        } else {
            $user = $userRepository->find($id);
            $action = "bearbeiten";
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!empty($form->get('plainPassword')->getData())) {
                // encode the plain password
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $this->addFlash('success', 'Benutzer erfolgreich gespeichert.');
            } else {
                $this->addFlash('error', 'Kein Password gefunden');
            }
            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/form.html.twig', [
            'action' => $action,
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     * @param Request $request
     * @param UserRepository $userRepository
     * @param int $id
     * @return Response
     */
    public function deleteAction(
        Request $request,
        UserRepository $userRepository,
        int $id
    ): Response
    {
        $user = $userRepository->find($id);
        if (empty($user)) {
            $this->addFlash('error','Benutzer mit der Id:'.$id.' nicht gefunden.');

        }elseif ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        } else {
            $this->addFlash('error','Sicherheitsüberprüfung fehlgeschlagen bitte versuche Sie es erneut.');
        }

        return $this->redirectToRoute('user_index');
    }
}
