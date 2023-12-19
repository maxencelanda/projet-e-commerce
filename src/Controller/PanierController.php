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
    private CartRepository $cartRepository;

    public function __construct(ProductRepository $productRepository, AccountRepository $accountRepository, CartRepository $cartRepository)
    {
        
        $this->productRepository = $productRepository;
        $this->cartRepository = $cartRepository;
        
    }

    #[Route('/panier', name: 'app_panier')]
    public function index(int $id): Response
    {
        $products = [];
        
        $cart = $this->cartRepository->findByUser($id);
        if ($cart){
            foreach($cart as $product){
                array_push($products, $this->productRepository->find($cart->getIdProduct()));
            }
        }
        
        
        return $this->render(
            'panier/index.html.twig', [
            'products' => $this->productRepository->findAll(),
            //'products' => $products,
        ]);
    }
}
