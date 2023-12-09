<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Product;
use App\Repository\ProductRepository;

class MenuController extends AbstractController
{

    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    #[Route('/menu', name: 'app_menu')]
    public function index(): Response
    {
        return $this->render(
            'menu/index.html.twig', [
            'products' => $this->productRepository->findAll(),
        ]);
    }
}
