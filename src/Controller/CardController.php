<?php

namespace App\Controller;

use App\Repository\CardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
