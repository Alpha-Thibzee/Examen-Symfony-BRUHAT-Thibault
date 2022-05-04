<?php

namespace App\Controller;


use App\Form\MailFormType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Transport\TransportInterface;

class MailerController extends AbstractController
{
    #[Route('/mailer', name: 'mailer')]
    public function index(Request $request, TransportInterface $mailer)
    {
        $form = $this->createForm(MailFormType::class);

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();
            
            $message = (new Email())
                ->from($contactFormData['email'])
                ->to('your@mail.com')
                ->subject('Nouvelle propositon d\'achat')
                ->text('Sender : '.$contactFormData['email'].\PHP_EOL.
                    $contactFormData['message'],
                    'text/plain');

                    try {
                        $mailer->send($message);
                    } catch (TransportExceptionInterface $e) {
                    }




            $this->addFlash('success', 'Your message has been sent');

            return $this->redirectToRoute('homepage');
        }



        return $this->render('mailer/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
}
