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
        /*$productChosen = $request->query->get("productChosen");
        if ($productChosen && $this->accountRepository->find($id)){
            Si pas de panier pour le user -> créer un panier avec le produit choisi
            Sinon -> ajoute le produit choisi dans le panier
        }*/
        return $this->render(
            'menu/index.html.twig',
            [
                'products' => $this->productRepository->findAll(),
                'categories' => $this->categoryRepository->findAll(),
                'chosenCategory' => 'none',
            ]
        );
    }

    #[Route('/menu/{categ}', name: 'app_menu_category')]
    public function category(string $categ): Response
    {
        return $this->render(
            'menu/index.html.twig',
            [
                'products' => $this->productRepository->findByCategory($categ),
                'categories' => $this->categoryRepository->findAll(),
                'chosenCategory' => $this->categoryRepository->find($categ),
            ]
        );
    }
}
