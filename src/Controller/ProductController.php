<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Vendor;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Service\ProductImageHelper;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('/{id}', name: 'app_product_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository, Vendor $vendor): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findBy(['vendor' => $vendor]),
            'vendor' => $vendor
        ]);
    }

    #[Route('/{id}/new', name: 'app_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProductRepository $productRepository, Vendor $vendor, ProductImageHelper $productImageHelper): Response
    {
        $product = new Product();
        $product->setVendor($vendor);
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $productImages = $form->get('tempProductImages')->getData();
                $productImageHelper->setImages($productImages, $product);
            } catch (Exception $e) {

                $this->addFlash('error', $e->getMessage());
                
                return $this->redirectToRoute('app_product_new', ['id' => $vendor->getId()], Response::HTTP_SEE_OTHER);
            }
            
            $productRepository->save($product, true);
            $this->addFlash('success', 'Product created successfully.');

            return $this->redirectToRoute('app_product_index', ['id' => $vendor->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form,
            'vendor' => $vendor
        ]);
    }

    #[Route('/{id}/edit', name: 'app_product_edit', methods: ['GET', 'POST'], requirements: ['token' => '.+'])]
    public function edit(Request $request, Product $product, ProductRepository $productRepository, ProductImageHelper $productImageHelper): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $productImages = $form->get('tempProductImages')->getData();
                $productImageHelper->setImages($productImages, $product);
            } catch (Exception $e) {

                $this->addFlash('error', $e->getMessage());

                return $this->redirectToRoute('app_product_edit', ['id' => $product->getId()], Response::HTTP_SEE_OTHER);
            }

            $productRepository->save($product, true);
            $this->addFlash('success', 'Product updated successfully.');

            return $this->redirectToRoute('app_product_index', ['id' => $product->getVendor()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {
            $productRepository->remove($product, true);
        }

        $this->addFlash('success', 'Product deleted successfully.');

        return $this->redirectToRoute('app_product_index', ['id' => $product->getVendor()->getId()], Response::HTTP_SEE_OTHER);
    }
}
