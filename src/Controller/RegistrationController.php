<?php

namespace App\Controller;

use App\Entity\ActivationCode;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    use ControllerTrait;

    private UserPasswordEncoderInterface $passwordEncoder;
    private Swift_Mailer $mailer;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder,Swift_Mailer $mailer)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->mailer = $mailer;
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

            $this->verifierByActivationCodeCode($request, $user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            if ($user->isVerified()) {
                $this->addFlash('success', 'Sie können sich nun einloggen');

            } else {
                $this->addFlash
                (
                    'error'
                    , 'Der Aktivierungscode ist nicht im System.'.'
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

    private function verifierByActivationCodeCode(
        Request $request,
        User $user
    ): void
    {
        $entityManager = $this->getDoctrine()->getManager();
        $requestData = $request->request->get('registration_form');
        if (empty($requestData) || !isset($requestData['code']))
            return;

        $code = $requestData['code'];

        $repo = $entityManager->getRepository(ActivationCode::class);
        $activationCode = $repo->findOneBy(['code' => $code,'user' => null]);

        $mailTo[] = 'luhmann@netzhirsch.de';
        $subject = 'Neue Registrierung';
        $email = '';
        if (isset($requestData['email'])) {
            $email = $requestData['email'];
            $mailTo[] = $email;
        }

        if (empty($activationCode)) {
            $subject .= ' fehlgeschlagen';
            $message = 'Jemand hat versucht sich mit der E-Mail Adresse: '.$email;
            if (!empty($code))
                $message .= ' und dem Code:'.$code;
            $message .= ' zu registrieren.'.PHP_EOL.'Bitte aktivieren Sie gegebenenfalls den Benutzer.';
        } else {
            $subject .= ' erfolgt';
            $user->setIsVerified(true);
            $user->setActivationCode($activationCode);
            $message = 'Jemand hat sich mit der E-Mail Adresse: '.$email;
            if (!empty($code))
                $message .= ' und dem Code:'.$code;
            $message .= ' registriert.';
        }


        if ($this->sendMail($this->mailer, $mailTo, $subject, $message) < 1) {
            $this->addFlash
            (
                'error'
                ,'Es konnte leider keine E-Mail versandt werden, 
                bitte melden Sie sich direkt bei asspick@asspick.de');
        }

    }
}
