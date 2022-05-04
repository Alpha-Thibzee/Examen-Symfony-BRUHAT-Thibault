<?php

namespace App\Controller;

use App\Entity\Card;
use App\Form\CardType;
use App\Service\Upload;
use App\Form\FilterType;
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
    public function viewAll(CardRepository $repo, Request $request): Response
    {
        $card = $repo->findAll();
        $filter = $this->createForm(FilterType::class);
        $filter->handleRequest($request);

        if($filter->isSubmitted() && $filter->isValid()){
            $order = ($filter['valueOrder']->getData()? 'ASC' : 'DESC');
            $card = $repo->filterArticle($order);
        }


        return $this->render('card/index.html.twig' , [
            "card" => $card,
            'filter' => $filter->createView()
        ]);
    }

    #[Route('/admin/add-card', name: 'add-card')]
        public function new(Request $request, EntityManagerInterface $em, Upload $fileUploader): Response
    {
        $card = new Card();
        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $avatarFile = $form->get("picture")->getData();
                $avatarFileName = $fileUploader->upload($avatarFile) ;
                $card->setPicture($avatarFileName);
            if($card->getPicture() === null) {
                $card->setPicture("NoAvailable.png");
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
    public function edit(EntityManagerInterface $em, Card $card, Request $request , Upload $fileUploader): Response
    {
        $oldAvatar = $card->getPicture();

        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);
       

        if($form->isSubmitted() && $form->isValid()){

            $avatarFile = $form->get('picture')->getData();
            if ($avatarFile) {
                if($avatarFile !== 'default.png'){
                    $fileUploader->fileDelete($oldAvatar);
                }
                $avatarFileName = $fileUploader->upload($avatarFile);
                $card->setPicture($avatarFileName);
            }
            $em->flush();
            return $this->redirectToRoute('all-card');
        }

        return $this->render('card/edit.html.twig', [
            'form' => $form->createView()
        ]);


    }

    #[Route('/delete-card/{id}', name: 'delete-card')]
    public function delete(Card $card, EntityManagerInterface $em): Response
    {
        $em->remove($card);
        try {
            $em->flush();
        }catch(Exception $e) {

        }
        

        return $this->redirectToRoute('all-card');
    }
    }
    
