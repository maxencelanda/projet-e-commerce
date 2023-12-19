<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Product;
use App\Entity\Category;
use App\Form\CreateProductType;
use App\Form\CreateCategoryType;
use App\Form\DeleteProductType;
use App\Form\EditProductType;
use App\Repository\ProductRepository;

class AdminController extends AbstractController
{

    #[Route('/admin/create/product', name: 'app_admin_create_product')]
    public function createProduct(Request $request, EntityManagerInterface $entityManager): Response
    {
        
        $product = new Product();
        $form = $this->createForm(CreateProductType::class, $product);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() and $form->isValid()){
            $product = $form->getData();
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->render('admin/createProduct.html.twig', [
                'form' => $form,
                'success' => "Produit créé avec succès",
            ]);
        }

        return $this->render('admin/createProduct.html.twig', [
            'form' => $form,
            'success' => '',
        ]);
    }

    #[Route('/admin/edit/product', name: 'app_admin_edit_product')]
    public function editProduct(Request $request, EntityManagerInterface $entityManager): Response
    {
        
        $product = new Product();
        $form = $this->createForm(EditProductType::class, $product, array('method' => 'PUT'));
        $form->handleRequest($request);
        
        if ($form->isSubmitted() and $form->isValid()){
            $productData = $form->getData();
            var_dump($productData);
            $product = $entityManager->getRepository(Product::class)->findByName    ($productData->getId());
            if (!$product) {
                throw $this->createNotFoundException(
                    'No product found for id '.$productData->getId()
                );
            }
            $product->setName($productData->getName());
            $product->setPrice($productData->getPrice());
            $product->setQuantity($productData->getQuantity());
            $product->setDescription($productData->getDescription());
            $product->setImage($productData->getImage());
            $product->setIdCategory($productData->getIdCategory());
            $entityManager->flush();
            return $this->render('admin/editProduct.html.twig', [
                'form' => $form,
                'success' => "Produit modifié avec succès",
            ]);
        }

        return $this->render('admin/editProduct.html.twig', [
            'form' => $form,
            'success' => '',
        ]);
    }

    #[Route('/admin/create/category', name: 'app_admin_create_category')]
    public function createCategory(Request $request, EntityManagerInterface $entityManager): Response
    {
        
        $category = new Category();
        $form = $this->createForm(CreateCategoryType::class, $category);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() and $form->isValid()){
            $category = $form->getData();
            $entityManager->persist($category);
            $entityManager->flush();
            return $this->render('admin/createCategory.html.twig', [
                'form' => $form,
                'success' => "Produit créé avec succès",
            ]);
        }

        return $this->render('admin/createCategory.html.twig', [
            'form' => $form,
            'success' => '',
        ]);
    }

    #[Route('/admin/delete/product', name: 'app_admin_delete_product')]
    public function deleteProduct(Request $request, EntityManagerInterface $entityManager): Response
    {
        
        $form = $this->createForm(DeleteProductType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() and $form->isValid()){
            $productData = $form->get('id')->getData();
            $product = $entityManager->getRepository(Product::class)->find($productData);
            $entityManager->remove($product);
            $entityManager->flush();
            return $this->render('admin/deleteProduct.html.twig', [
                'form' => $form,
                'success' => "Produit supprimé avec succès",
            ]);
        }

        return $this->render('admin/deleteProduct.html.twig', [
            'form' => $form,
            'success' => '',
        ]);
    }

    #[Route('/admin/edit/category', name: 'app_admin_edit_category')]
    public function editCategory(Request $request, EntityManagerInterface $entityManager): Response
    {
        
        $product = new Product();
        $form = $this->createForm(EditProductType::class, $product, array('method' => 'PUT'));
        $form->handleRequest($request);
        
        if ($form->isSubmitted() and $form->isValid()){
            $productData = $form->getData();
            var_dump($productData);
            $product = $entityManager->getRepository(Product::class)->findByName    ($productData->getId());
            if (!$product) {
                throw $this->createNotFoundException(
                    'No product found for id '.$productData->getId()
                );
            }
            $product->setName($productData->getName());
            $product->setPrice($productData->getPrice());
            $product->setQuantity($productData->getQuantity());
            $product->setDescription($productData->getDescription());
            $product->setImage($productData->getImage());
            $product->setIdCategory($productData->getIdCategory());
            $entityManager->flush();
            return $this->render('admin/editProduct.html.twig', [
                'form' => $form,
                'success' => "Produit modifié avec succès",
            ]);
        }

        return $this->render('admin/editProduct.html.twig', [
            'form' => $form,
            'success' => '',
        ]);
    }

    #[Route('/admin/delete/category', name: 'app_admin_delete_category')]
    public function deleteCategory(Request $request, EntityManagerInterface $entityManager): Response
    {
        
        $form = $this->createForm(DeleteProductType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() and $form->isValid()){
            $productData = $form->get('id')->getData();
            $product = $entityManager->getRepository(Product::class)->find($productData);
            $entityManager->remove($product);
            $entityManager->flush();
            return $this->render('admin/deleteProduct.html.twig', [
                'form' => $form,
                'success' => "Produit supprimé avec succès",
            ]);
        }

        return $this->render('admin/deleteProduct.html.twig', [
            'form' => $form,
            'success' => '',
        ]);
    }
}
