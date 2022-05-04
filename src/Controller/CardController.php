<?php

namespace App\Controller;

use App\Entity\Card;
use App\Form\CardType;
use App\Service\Upload;
use App\Repository\CardRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CardController extends AbstractController
{
    #[Route('/all-card', name: 'all-card')]
    public function viewAll(CardRepository $repo): Response
    {
        $card = $repo->findAll();

        return $this->render('card/index.html.twig' , [
            "card" => $card
        ]);
    }

    #[Route('/add-card', name: 'add-card')]
        public function new(Request $request, EntityManagerInterface $em, Upload $fileUploader): Response
    {
        $card = new Card();
        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);
        $card->setBuyAt(new \DateTimeImmutable("now"));
        $card->setReleaseAt(new \DateTimeImmutable("now"));

        if($form->isSubmitted() && $form->isValid()){
            if($card->getPicture() === null) {
                $card->setPicture("1.png");
            } else {
                $avatarFile = $form->get("picture")->getData();
                $avatarFileName = $fileUploader->upload($avatarFile) ;
                $card->setPicture($avatarFileName);
            }
            $em->persist($card);
            
            try{
                $em->flush();
            }catch(Exception $e){
                return $this->redirectToRoute('add-card');
            }
            return $this->redirectToRoute('all-card');
        }
        
        return $this->render('card/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/view-one/{id}', name: 'view-one')]
    public function viewOne(CardRepository $repository, $id): Response
    {
        $card = $repository->findOneBy(['id' => $id]);

        return $this->render('card/one.html.twig', [
            'card' => $card
        ]);
    }

    #[Route('/edit-card/{id}', name: 'edit-card')]
    public function edit(EntityManagerInterface $em, Card $card, Request $request): Response
    {
        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);
       

        if($form->isSubmitted() && $form->isValid()){

            $em->flush();
            return $this->redirectToRoute('all-card');
        }

        return $this->render('card/edit.html.twig', [
            'form' => $form->createView()
        ]);


    }
    }
    
