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
        $session = $request->getSession();
        if (!$session->has('user')){
            return $this->redirectToRoute('accueil');
        }
        return $this->render(
            'menu/index.html.twig', [
            'products' => $this->productRepository->findAll(),
            'categories' => $this->categoryRepository->findAll(),
            'chosenCategory' => 'none',
        ]);
    }

    #[Route('/menu/{categ}', name: 'app_menu_category')]
    public function category(string $categ, Request $request): Response
    {
        $session = $request->getSession();
        if (!$session->has('user')){
            return $this->redirectToRoute('accueil');
        }
        return $this->render(
            'menu/index.html.twig', [
            'products' => $this->productRepository->findByCategory($categ),
            'categories' => $this->categoryRepository->findAll(),
            'chosenCategory' => $this->categoryRepository->find($categ),
        ]);
    }

    #[Route('/menu/plat/{idPlat}', name: 'app_menu_plat')]
    public function plat(string $idPlat, Request $request): Response
    {
        $session = $request->getSession();
        if (!$session->has('user')){
            return $this->redirectToRoute('accueil');
        }
        return $this->render(
            'menu/plat.html.twig', [
            'product' => $this->productRepository->find($idPlat),
        ]);
    }
}
