<?php


namespace App\Controller;

use App\Form\FeedbackFormType;
use App\Struct\Email\Email;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/feedback")
 */
class FeedbackController extends AbstractController
{
    use ControllerTrait;
    /**
     * @Route("/", name="feedback")
     */
    public function formAction(Request $request,Swift_Mailer $mailer)
    {
        $form = $this->createForm(FeedbackFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            if (isset($data['message']) && !empty(isset($data['message']))) {
                $message = $data['message'];
                $email = new Email();
//                $email->setTo($email->getFrom());
                $email->setTo('luhmann@netzhirsch.de');
                $email->setSubject('Feedback');
                $email->setMessage($message);

                $this->sendMail($mailer, $email,true);
            }

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('feedback/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}