<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Cart;
use App\Entity\Product;
use App\Form\TypeOrderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use App\Repository\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\Request;

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
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $session = $request->getSession();
        if (!$session->has('user')){
            return $this->redirectToRoute('accueil');
        }

        $user = $entityManager->getRepository(Account::class)->find($session->get('id'));
        $cart = $entityManager->getRepository(Cart::class)->findBy(['account' => $user]);
        $products = array();
        $quantities = array();

        $form = $this->createForm(TypeOrderType::class);
        $form->handleRequest($request);

        foreach($cart as $c){
            array_push($products, $c->getProduct());
            array_push($quantities, $c->getQuantity());
        }

        return $this->render(
            'panier/index.html.twig', [
            'products' => $products,
            'quantities' => $quantities,
            'form' => $form,
        ]);
    }

    #[Route('/panier/{id}/{c}', name: 'app_panier_remove')]
    public function indexRemove($id, $c, Request $request, EntityManagerInterface $entityManager): Response
    {
        $session = $request->getSession();
        if (!$session->has('user')){
            return $this->redirectToRoute('accueil');
        }

        $user = $entityManager->getRepository(Account::class)->find($session->get('id'));
        $cart = $entityManager->getRepository(Cart::class)->findBy(['account' => $user]);

        $product = $entityManager->getRepository(Product::class)->find($id);
        $cart[$c]->removeProduct($product);
        $entityManager->remove($cart[$c]);
        $entityManager->flush();

        return $this->redirectToRoute("app_panier");
    }
}
