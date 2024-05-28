<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Cart;
use App\Entity\Orders;
use App\Entity\Product;
use App\Entity\TypeOrder;
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

        foreach($cart as $c){
            array_push($products, $c->getProduct());
            array_push($quantities, $c->getQuantity());
        }

        $form = $this->createForm(TypeOrderType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()){
            
            $typeOrder = $form->get("typeOrder")->getData();
            $order = new Orders();
            $order->setAccount($user);
            $order->setDateOrder(new \DateTime('now'));
            $order->setTypeOrder($typeOrder);
            $entityManager->persist($order);
            $entityManager->flush();
            return $this->render('panier/index.html.twig', [
                'products' => $products,
                'quantities' => $quantities,
                'form' => $form,
                'success' => "Commande effectuée avec succès",
            ]);
        }

        return $this->render(
            'panier/index.html.twig', [
            'products' => $products,
            'quantities' => $quantities,
            'form' => $form,
            'success' => "",
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
