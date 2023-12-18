<?php

namespace App\Controller;

use App\Entity\Account;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AccountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'login')]
    public function index(Request $request, AccountRepository $accountRepository): Response
    {
        $user = null;
        //dump($request);
        if ($request->request->count() > 0) {
            $user = new Account();
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            // Vérifie si les valeurs existent dans la base de données
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
    #[Route(path: '/register', name: 'register')]
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = null;
        if ($request->request->count() > 0) {
            $password = $request->request->get('password');
            $checkPassword = $request->request->get('check_password');
            if ($password == $checkPassword) {
                $user = new Account();
                $user->setName($request->request->get('name'))
                    ->setEmail($request->request->get('email'))
                    ->setPassword($request->request->get('email'))
                    ->setRole(null);

                $entityManager->persist($user);

                // actually executes the queries (i.e. the INSERT query)
                $entityManager->flush();
            } else {
                return $this->render('login/register.html.twig', [
                    'controller_name' => 'HomeController',
                ]);
            }
        }
        return $this->render('login/register.html.twig', [
            'controller_name' => 'HomeController',
        ]);
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
