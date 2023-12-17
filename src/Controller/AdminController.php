<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CreateProductType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Product;

class AdminController extends AbstractController
{

    #[Route('/admin/create/product', name: 'app_admin_create_product')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        
        $product = new Product();
        $form = $this->createForm(CreateProductType::class, $product);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() and $form->isValid()){
            $product = $form->getData();
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->render('admin/index.html.twig', [
                'form' => $form,
                'success' => "Produit créé avec succès",
            ]);
        }
        

        return $this->render('admin/index.html.twig', [
            'form' => $form,
            'success' => '',
        ]);
    }
}
