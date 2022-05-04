<?php

namespace App\Controller;


use App\Entity\Card;
use App\Form\MailFormType;
use Symfony\Component\Mime\Email;
use App\Repository\CardRepository;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class MailerController extends AbstractController
{
    #[Route('/mailer/{id}', name: 'mailer')]
    public function index(CardRepository $card , Card $cards ,Request $request, TransportInterface $mailer, $id)
    {
        $card->findOneBy(['id' => $id]);
        $card = $cards->getValue();
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
            'card' => $card,
            'form' => $form->createView()
        ]);
    }
    
}
