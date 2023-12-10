<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Entity\Category;
use App\Repository\CategoryRepository;

class MenuController extends AbstractController
{

    private ProductRepository $productRepository;
    private CategoryRepository $categoryRepository;

    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    #[Route('/menu', name: 'app_menu')]
    public function index(): Response
    {
        return $this->render(
            'menu/index.html.twig', [
            'products' => $this->productRepository->findAll(),
            'categories' => $this->categoryRepository->findAll(),
        ]);
    }

    #[Route('/menu/{categ}', name: 'app_menu_category')]
    public function category(string $categ): Response
    {
        return $this->render(
            'menu/index.html.twig', [
            'products' => $this->productRepository->findByCategory($categ),
            'categories' => $this->categoryRepository->findAll(),
        ]);
    }
}
