<?php

namespace App\Controller;

use App\Entity\Fibu;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    private UserPasswordEncoderInterface $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/register", name="app_register")
     * @param Request $request
     * @return Response
     */
    public function register(
        Request $request
    ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->encodePlainPassword($user, $form);

            $this->verifierByFiboCode($request, $user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            if ($user->isVerified()) {
                $this->addFlash('success', 'Sie können sich nun einloggen');

            } else {
                $this->addFlash
                (
                    'error'
                    , 'Die Daten Ihrer Finanzbuchhalten sind nicht im System.'.'
                     Ein Admin muss Ihren Account aktivieren');
            }
            return $this->redirectToRoute('login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    private function encodePlainPassword(User $user,$form){
        $user->setPassword(
            $this->passwordEncoder->encodePassword(
                $user,
                $form->get('plainPassword')->getData()
            )
        );
    }

    private function verifierByFiboCode(
        Request $request,
        User $user
    ): void
    {
        $entityManager = $this->getDoctrine()->getManager();
        $requestData = $request->request->get('registration_form');
        if (empty($requestData) || !isset($requestData['code']) || !isset($requestData['intermediaryName']))
            return;

        $fiboCode = $requestData['code'];
        $intermediaryName = $requestData['intermediaryName'];

        $repo = $entityManager->getRepository(Fibu::class);
        $fibu = $repo->findBy(['code' => $fiboCode,'intermediaryName' => $intermediaryName]);

        if (!empty($fibu))
            $user->setIsVerified(true);

    }
}
