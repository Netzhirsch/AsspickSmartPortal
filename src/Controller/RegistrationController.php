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
        $requestData = $request->request->get('registration_form');
        if (empty($requestData) || !isset($requestData['email']))
            return;

		$email = $requestData['email'];

        $code = (isset($requestData['code'])?$requestData['code']:'');

        $entityManager = $this->getDoctrine()->getManager();
        $repo = $entityManager->getRepository(ActivationCode::class);
        $activationCode = $repo->findOneBy(['email' => $email,'code' => $code,'user' => null]);

        $emailAddressAdmin = 'luhmann@netzhirsch.de';
        $subject = 'Neue Registrierung';
        $emailAddressUser = '';
        if (isset($requestData['email'])) {
            $emailAddressUser = $requestData['email'];
        }

        $messageUser = 'Danke für ihre Registrierung.';

        $subject .= ' fehlgeschlagen';

        $messageAdmin = 'Jemand hat versucht sich mit der E-Mail Adresse: '.$emailAddressUser;
        if (!empty($code))
            $messageAdmin .= ' und dem Code:'.$code;
        $messageAdmin .= ' zu registrieren.'.PHP_EOL.'Bitte aktivieren Sie gegebenenfalls den Benutzer.';

        $messageUser .= 'Sie können sich nun einloggen.';

        if (!empty($activationCode)) {

            $subject .= ' erfolgt';

            $messageAdmin = 'Jemand hat sich mit der E-Mail Adresse: '.$emailAddressUser;
            if (!empty($code))
                $messageAdmin .= ' und dem Code:'.$code;
            $messageAdmin .= ' registriert.';

            $messageUser .= PHP_EOL.'Ihr Account muss noch von einem Admin freigeschaltet werden.';

            $user->setIsVerified(true);
            $user->setActivationCode($activationCode);
        }


        if
        (
            !$this->isMailSendToReceiver($emailAddressAdmin,$subject,$messageAdmin)
            &&
            !$this->isMailSendToReceiver($emailAddressUser,'Danke für ihre Registrierung',$messageUser)
        )
            {
                $this->addFlash
                (
                    'error'
                    ,'Es konnte leider keine E-Mail versandt werden, 
                    bitte melden Sie sich direkt bei asspick@asspick.de');
            }

    }

    private function isMailSendToReceiver(string $emailAddressAdmin,string $subject,string $messageAdmin): bool
    {
        return $this->sendMail($this->mailer, $emailAddressAdmin, $subject, $messageAdmin) > 0;
    }


}
