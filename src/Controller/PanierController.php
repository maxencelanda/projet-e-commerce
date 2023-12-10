<?php

namespace App\Controller;

use App\Entity\Account;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use App\Repository\AccountRepository;
use Doctrine\ORM\Mapping\Id;

class PanierController extends AbstractController
{

    private ProductRepository $productRepository;
    private AccountRepository $accountRepository;
    private CartRepository $cartRepository;


    public function __construct(ProductRepository $productRepository, AccountRepository $accountRepository, CartRepository $cartRepository)
    {
        $this->productRepository = $productRepository;
        $this->accountRepository = $accountRepository;
        $this->cartRepository = $cartRepository;
    }

    #[Route('/panier', name: 'app_panier')]
    public function index(int $id): Response
    {
        return $this->render(
            'panier/index.html.twig', [
            'account' => $this->accountRepository->find($id),
            'products' => $this->productRepository->findAll(),
        ]);
    }
}
