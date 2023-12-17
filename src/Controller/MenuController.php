<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\AccountRepository;
use App\Repository\CartRepository;
use App\Entity\Cart;

class MenuController extends AbstractController
{

    private ProductRepository $productRepository;
    private CategoryRepository $categoryRepository;
    private AccountRepository $accountRepository;
    private CartRepository $cartRepository;

    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository, AccountRepository $accountRepository, CartRepository $cartRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->accountRepository = $accountRepository;
        $this->cartRepository = $cartRepository;
    }

    #[Route('/menu', name: 'app_menu')]
    public function index(Request $request): Response
    {
        return $this->render('menu/index.html.twig', [
            'controller_name' => 'MenuController',
        ]);
    }
}
