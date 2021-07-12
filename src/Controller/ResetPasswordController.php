<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\ResetPasswordRequestFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

/**
 * @Route("/reset-password")
 */
class ResetPasswordController extends AbstractController
{
    use ResetPasswordControllerTrait;

    private $resetPasswordHelper;

    public function __construct(ResetPasswordHelperInterface $resetPasswordHelper)
    {
        $this->resetPasswordHelper = $resetPasswordHelper;
    }

    /**
     * Display & process form to request a password reset.
     *
     * @Route("", name="app_forgot_password_request")
     */
    public function request(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ResetPasswordRequestFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->processSendingPasswordResetEmail(
                $form->get('email')->getData(),
                $mailer
            );
        }

        return $this->render('reset_password/request.html.twig', [
            'requestForm' => $form->createView(),
        ]);
    }

    /**
     * Confirmation page after a user has requested a password reset.
     *
     * @Route("/check-email", name="app_check_email")
     */
    public function checkEmail(): Response
    {
        // Generate a fake token if the user does not exist or someone hit this page directly.
        // This prevents exposing whether or not a user was found with the given email address or not
        $expiresAt = null;
        if (empty($this->getTokenObjectFromSession())) {
            $resetToken = $this->resetPasswordHelper->generateFakeResetToken();
            $expiresAt = $resetToken->getExpiresAt();
        }

        return $this->render('reset_password/check_email.html.twig', [
            'expiresAt' => $expiresAt,
        ]);
    }

    /**
     * Validates and process the reset URL that the user clicked in their email.
     *
     * @Route("/reset/{token}", name="app_reset_password")
     */
    public function reset(Request $request, UserPasswordHasherInterface $passwordEncoder, string $token = null): Response
    {
        if ($token) {
            // We store the token in session and remove it from the URL, to avoid the URL being
            // loaded in a browser and potentially leaking the token to 3rd party JavaScript.
            $this->storeTokenInSession($token);

            return $this->redirectToRoute('app_reset_password');
        }

        $token = $this->getTokenFromSession();
        if (null === $token) {
            $this->addFlash('error', 'Link ist abgelaufen bitte setzen Sie das Passwort erneut zurück.');
            return $this->redirectToRoute('app_forgot_password_request');
        }

        try {
            /** @var User $user */
            $user = $this->resetPasswordHelper->validateTokenAndFetchUser($token);
        } catch (ResetPasswordExceptionInterface $e) {
            $this->addFlash('error', 'Link ist abgelaufen bitte setzen Sie das Passwort erneut zurück.');

            return $this->redirectToRoute('app_forgot_password_request');
        }

        // The token is valid; allow the user to change their password.
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // A password reset token should be used only once, remove it.
            $this->resetPasswordHelper->removeResetRequest($token);

            // Encode the plain password, and set it.
            $encodedPassword = $passwordEncoder->hashPassword(
                $user,
                $form->get('plainPassword')->getData()
            );

            $user->setPassword($encodedPassword);
            $this->getDoctrine()->getManager()->flush();

            // The session is cleaned up after the password has been changed.
            $this->cleanSessionAfterReset();
            $this->addFlash('success', 'Passwort erfolgreich zurückgesetzt.');
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('reset_password/reset.html.twig', [
            'resetForm' => $form->createView(),
        ]);
    }

    private function processSendingPasswordResetEmail(string $emailFormData, MailerInterface $mailer): RedirectResponse
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy([
            'email' => $emailFormData,
        ]);

        // Do not reveal whether a user account was found or not.
        if (!$user) {
            $this->addFlash('error', 'Benutzer mit der E-Mail-Adresse '.$emailFormData.' nicht gefunden.');
            return $this->redirectToRoute('app_check_email');
        }

        try {
            $resetToken = $this->resetPasswordHelper->generateResetToken($user);
        } catch (ResetPasswordExceptionInterface $e) {
             $this->addFlash('error', sprintf(
                 'Es gab ein Problem bei der Bearbeitung Ihrer Anfrage zum Zurücksetzen des Passworts - %s',
                 $e->getReason()
             ));

            return $this->redirectToRoute('app_forgot_password_request');
        }

        $email = new Email();

        $this->createSignature($email);

        $html = $this->renderView('reset_password/email.html.twig',['resetToken' => $resetToken]);

        $email
            ->from(new Address('luhmann@netzhirsch.de', 'Asspick Smart Portal'))
            ->to($user->getEmail())
            ->subject('Passwort neu setzen beim Asspick Smart Portal')
            ->html($html)
        ;

        try {
            $mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            $this->addFlash('error', sprintf(
                'Es gab ein Problem bei der Bearbeitung Ihrer Anfrage zum Zurücksetzen des Passworts - %s',
                $e->getMessage()
            ));

            return $this->redirectToRoute('app_forgot_password_request');
        }

        // Store the token object in session for retrieval in check-email route.
        $this->setTokenObjectInSession($resetToken);

        return $this->redirectToRoute('app_check_email');
    }

    private function createSignature(Email $email)
    {


        $imagePaths = dirname(__DIR__,2)
            .DIRECTORY_SEPARATOR
            .'assets'
            .DIRECTORY_SEPARATOR
            .'img'
            .DIRECTORY_SEPARATOR
            .'signatur'
        ;
        foreach (scandir($imagePaths) as $imagePath) {
            if ($imagePath == '.' || $imagePath == '..')
                continue;

            $fullPath = $imagePaths.DIRECTORY_SEPARATOR.$imagePath;

            $imagePath = strtolower($imagePath);

            switch ($imagePath) {
                case 'datenschutz.png':
                    $email->embedFromPath($fullPath,'dataProtection');
                    break;
                case 'facebook.png':
                    $email->embedFromPath($fullPath,'facebook');
                    break;
                case 'homepage.png':
                    $email->embedFromPath($fullPath,'homepage');
                    break;
                case 'imagefilm.png':
                    $email->embedFromPath($fullPath,'imageFilm');
                    break;
                case 'impressum.png':
                    $email->embedFromPath($fullPath,'impress');
                    break;
                case 'logo.jpg':
                    $email->embedFromPath($fullPath,'logo');
                    break;
            }
        }

    }
}
