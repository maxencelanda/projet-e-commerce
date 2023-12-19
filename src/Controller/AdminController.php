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
use App\Form\DeleteCategoryType;
use App\Form\EditCategoryType;
use App\Form\EditProductType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;

class AdminController extends AbstractController
{

    #[Route('/admin/create/product', name: 'app_admin_create_product')]
    public function createProduct(Request $request, EntityManagerInterface $entityManager): Response
    {
        $session = $request->getSession();
        if (!$session->has('user')){
            return $this->redirectToRoute('accueil');
        }
        if ($session->get('role') != "Admin"){
            return $this->redirectToRoute('accueil');
        }

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
    public function editProduct(Request $request, EntityManagerInterface $entityManager, ProductRepository $productRepository): Response
    {
        $session = $request->getSession();
        if (!$session->has('user')){
            return $this->redirectToRoute('accueil');
        }
        if ($session->get('role') != "Admin"){
            return $this->redirectToRoute('accueil');
        }

        $products = $productRepository->findAll();

        return $this->render('admin/editProduct.html.twig', [
            'products' => $products,
            'success' => '',
        ]);
    }

    #[Route('/admin/edit/product/{id}', name: 'app_admin_edit_product_id')]
    public function editProductId(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $session = $request->getSession();
        if (!$session->has('user')){
            return $this->redirectToRoute('accueil');
        }
        if ($session->get('role') != "Admin"){
            return $this->redirectToRoute('accueil');
        }

        $form = $this->createForm(EditProductType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() and $form->isValid()){
            $product = $entityManager->getRepository(Product::class)->find($id);
            if (!$product) {
                throw $this->createNotFoundException(
                    'No product found for id '.$id
                );
            }
            $product->setName($form->get('name')->getData());
            $product->setPrice($form->get('price')->getData());
            $product->setQuantity($form->get('quantity')->getData());
            $product->setDescription($form->get('description')->getData());
            $product->setImage($form->get('image')->getData());
            $product->setCategory($form->get('category')->getData());
            $entityManager->flush();
            return $this->render('admin/editProductRedirect.html.twig', [
                'form' => $form,
                'success' => "Produit modifié avec succès",
            ]);
        }

        return $this->render('admin/editProductRedirect.html.twig', [
            'form' => $form,
            'success' => '',
        ]);
    }

    #[Route('/admin/delete/product', name: 'app_admin_delete_product')]
    public function deleteProduct(Request $request, EntityManagerInterface $entityManager): Response
    {
        $session = $request->getSession();
        if (!$session->has('user')){
            return $this->redirectToRoute('accueil');
        }
        if ($session->get('role') != "Admin"){
            return $this->redirectToRoute('accueil');
        }

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

    #[Route('/admin/create/category', name: 'app_admin_create_category')]
    public function createCategory(Request $request, EntityManagerInterface $entityManager): Response
    {
        $session = $request->getSession();
        if (!$session->has('user')){
            return $this->redirectToRoute('accueil');
        }
        if ($session->get('role') != "Admin"){
            return $this->redirectToRoute('accueil');
        }

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

    #[Route('/admin/edit/category/{id}', name: 'app_admin_edit_category_id')]
    public function editCategoryId(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $session = $request->getSession();
        if (!$session->has('user')){
            return $this->redirectToRoute('accueil');
        }
        if ($session->get('role') != "Admin"){
            return $this->redirectToRoute('accueil');
        }

        $form = $this->createForm(EditCategoryType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() and $form->isValid()){
            $category = $entityManager->getRepository(Category::class)->find($id);
            if (!$category) {
                throw $this->createNotFoundException(
                    'No product found for id '.$id
                );
            }
            $category->setName($form->get('name')->getData());
            $entityManager->flush();
            return $this->render('admin/editProductRedirect.html.twig', [
                'form' => $form,
                'success' => "Produit modifié avec succès",
            ]);
        }

        return $this->render('admin/editProductRedirect.html.twig', [
            'form' => $form,
            'success' => '',
        ]);
    }

    #[Route('/admin/edit/category', name: 'app_admin_edit_category')]
    public function editCategory(Request $request, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
    {
        $session = $request->getSession();
        if (!$session->has('user')){
            return $this->redirectToRoute('accueil');
        }
        if ($session->get('role') != "Admin"){
            return $this->redirectToRoute('accueil');
        }

        $categories = $categoryRepository->findAll();

        return $this->render('admin/editCategory.html.twig', [
            'categories' => $categories,
            'success' => '',
        ]);
    }

    #[Route('/admin/delete/category', name: 'app_admin_delete_category')]
    public function deleteCategory(Request $request, EntityManagerInterface $entityManager): Response
    {
        $session = $request->getSession();
        if (!$session->has('user')){
            return $this->redirectToRoute('accueil');
        }
        if ($session->get('role') != "Admin"){
            return $this->redirectToRoute('accueil');
        }
        
        $form = $this->createForm(DeleteCategoryType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() and $form->isValid()){
            $productData = $form->get('id')->getData();
            $product = $entityManager->getRepository(Category::class)->find($productData);
            $entityManager->remove($product);
            $entityManager->flush();
            return $this->render('admin/deleteCategory.html.twig', [
                'form' => $form,
                'success' => "Categorie supprimée avec succès",
            ]);
        }

        return $this->render('admin/deleteCategory.html.twig', [
            'form' => $form,
            'success' => '',
        ]);
    }
}
