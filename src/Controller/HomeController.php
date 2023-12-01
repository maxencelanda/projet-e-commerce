<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')] // le / c'est le chemin du localhost : ça affiche: (render), le nom de la route : home 
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [ #il retourne une reponse : le render
            'controller_name' => 'HomeController',
        ]);
    }

    /* #[Route('/')] */
}
