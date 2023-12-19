<?php

namespace App\Controller;

use App\Entity\Account;
use App\Form\CheckAccountType;
use App\Repository\AccountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class HomeController extends AbstractController
{
    #[Route(path: '/login', name: 'login')]
    public function index(Request $request, AccountRepository $accountRepository): Response
    {
        $user = null;
        if ($request->request->count() > 0) {
            $user = new Account();
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            // Vérifier si les valeurs existent dans la base de données
            $user = $accountRepository->findOneBy(['email' => $email, 'password' => $password]);
        }
        if ($user) {
            return $this->redirectToRoute('accueil');
        } else {
            return $this->render('login/login.html.twig', [
                'controller_name' => 'HomeController',
            ]);
        }
    }

    #[Route(path: '/accueil', name: 'accueil')] # page de base
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
