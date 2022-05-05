<?php

namespace App\Controller;


use App\Entity\Card;
use App\Form\MailFormType;
use Symfony\Component\Mime\Email;
use App\Repository\CardRepository;
use Symfony\Component\Mailer\Transport;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
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
        $value = $cards->getValue()+1;
        $name = $cards->getName();
        $picture = $cards->getPicture();
        $form = $this->createForm(MailFormType::class);

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();
            
            $message = (new TemplatedEmail())
                ->from($contactFormData['email'])
                ->to('alexis@carte-collection.com')
                ->subject('Nouvelle propositon d\'achat pour la carte '.$name.' d\'une valeur de '. $contactFormData['value'].'€')
                ->text(
                    $contactFormData['message'],
                    'text/plain')
                ->htmlTemplate('mailer/reception.html.twig')
                ->context([
                    'mail' => $contactFormData["email"],
                    'name' => $contactFormData["fullName"],
                    'value' => $contactFormData["value"],
                    'message' => $contactFormData["message"],
                    'cardName' => $name,
                    'picture' => $picture
                ]);

                    try {
                        $mailer->send($message);
                        $this->addFlash('success', 'Votre proposition d\'offre à bien été envoyé');
                    } catch (TransportExceptionInterface $e) {
                        $this->addFlash('error', 'Votre proposition d\'offre n\'a pas été envoyé');
                        return $this->redirectToRoute('homepage');
                    }


            return $this->redirectToRoute('homepage');
        }
        
        return $this->render('mailer/index.html.twig', [
            'name' => $name,
            'value' => $value,
            'form' => $form->createView()
        ]);
    }
    
}
