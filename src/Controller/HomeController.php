<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'index')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [ #il retourne une reponse : le render
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route(path: '/accueil', name: 'accueil')]
    public function accueil(): Response
    {
        return $this->render('home/index.html.twig', [ #il retourne une reponse : le render
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route(path: '/aPropos', name: 'aPropos')]
    public function aPropos(): Response
    {
        return $this->render('home/aPropos.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
