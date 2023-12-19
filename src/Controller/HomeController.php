<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Cart;
use App\Entity\Role;
use App\Form\CheckAccountType;
use App\Form\RegisterType;
use App\Repository\AccountRepository;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route(path: '/index', name: 'login')]
    public function index(Request $request, AccountRepository $accountRepository,): Response
    {
        $user = null;
        if ($request->request->count() > 0) {
            $user = new Account();
            $email = $request->request->get('email');
            $password = $request->request->get('password');
            $hashedPW = hash('sha256', $password);
            // Vérifier si les valeurs existent dans la base de données
            $user = $accountRepository->findOneBy(['email' => $email, 'password' => $hashedPW]);
        }
        if ($user) {
            $session = $request->getSession();
            $session->set('id', $user->getId());
            $session->set('user', $user->getEmail());
            $session->set('role', $user->getRoles()->getName());
            return $this->redirectToRoute('accueil');
        } else {
            return $this->render('login/login.html.twig', [
                'controller_name' => 'HomeController',
            ]);
        }
    }

    #[Route(path: '/accueil', name: 'accueil')] # page de base
    public function accueil(Request $request): Response
    {
        return $this->render('home/index.html.twig', [ #il retourne une reponse : le render
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route(path: '/aPropos', name: 'aPropos')]
    public function aPropos(): Response
    {
        $account = null;
        return $this->render('home/aPropos.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/register', name: 'app_register')]
    public function createProduct(Request $request, EntityManagerInterface $entityManager): Response
    {
        
        $account = new Account();
        
        $form = $this->createForm(RegisterType::class, $account);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() and $form->isValid()){
            $account->setName($form->get('name')->getData());
            $account->setEmail($form->get('email')->getData());
            $hashedPW = hash('sha256', $form->get('password')->getData());
            $account->setPassword($hashedPW);
            $role = $entityManager->getRepository(Role::class)->find(1);
            $account->setRole($role);
            $entityManager->persist($account);
            $entityManager->flush();
            $cart = new Cart();
            $cart->setAccount($account);
            $cart->setQuantity(0);
            $account->setCart($cart);
            $entityManager->flush();
            $_SESSION["user"] = $account->getName();
            $_SESSION["role"] = $role->getName();
            return $this->redirectToRoute('accueil');
        }

        return $this->render('login/register.html.twig', [
            'form' => $form,
            'success' => '',
        ]);
    }

    #[Route(path: '/logout', name: 'logout')]
    public function logout(Request $request): Response
    {
        $request->getSession()->clear();
        return $this->render('login/login.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
