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

        if ($request->request->count() > 0) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            $user = $accountRepository->findOneBy(['email' => $email]);

            if ($user && password_verify($password, $user->getPassword())) {
                return $this->redirectToRoute('accueil');
            }
        }

        return $this->render('login/login.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route(path: '/register', name: 'register')]
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {

        $user = null;
        dump($request);
        if ($request->request->count() == 1) { // il faudrait faire une verif si l'email nexiste qu'une fois 

            $password = $request->request->get('password');
            $checkPassword = $request->request->get('check_password');

            if ($password == $checkPassword) {
                $user = new Account();
                $getMdp = $request->request->get('password');
                $passwordHash = password_hash($getMdp, PASSWORD_DEFAULT);

                $role = $entityManager->getRepository(\App\Entity\Role::class)->find(1);
                // dans le cas d'un plus long projet, faire des fonctions de verification.
                $user->setName($request->request->get('name'))
                    ->setEmail($request->request->get('email'))
                    ->setPassword($passwordHash)
                    ->setRole($role);

                $entityManager->persist($user);
                $entityManager->flush();

                return $this->render('home/login.html.twig', []);
            } else {
                return $this->render('login/register.html.twig', []);
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
