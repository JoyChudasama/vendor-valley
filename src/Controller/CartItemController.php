<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\CartItemHelper;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart/item')]
class CartItemController extends AbstractController
{
    #[Route('/{id}/new', name: 'app_cart_item_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CartItemHelper $cartItemHelper, Product $product): JsonResponse
    {
        try {
            $session = $request->getSession();

            $cartItemHelper->addToCart($product, $session);

            return new JsonResponse([
                'type' => 'success',
                'message' => 'Product Added to cart successfully!!!'
            ], 200);
        } catch (Exception $e) {
            return new JsonResponse([
                'type' => 'warning',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    #[Route('/{id}/remove', name: 'app_cart_item_remove', methods: ['GET', 'POST'])]
    public function remove(Request $request, CartItemHelper $cartItemHelper, Product $product): JsonResponse
    {
        try {
            $session = $request->getSession();

            $cartItemHelper->removeFromCart($product, $session, true);

            return new JsonResponse([
                'type' => 'success',
                'message' => 'Product Removed from cart successfully!!!'
            ], 200);
        } catch (Exception $e) {
            return new JsonResponse([
                'type' => 'warning',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    #[Route('/{id}/increase/quantity', name: 'app_cart_item_increase_quantity', methods: ['GET', 'POST'])]
    public function increaseQuantity(Request $request, CartItemHelper $cartItemHelper, Product $product): JsonResponse
    {
        try {
            $session = $request->getSession();

            $cartItemHelper->increaseQuantity($product, $session);

            return new JsonResponse([
                'type' => 'success',
                'message' => 'Product Quantity Increased successfully!!!'
            ], 200);
        } catch (Exception $e) {
            return new JsonResponse([
                'type' => 'warning',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    #[Route('/{id}/decrease/quantity', name: 'app_cart_item_decrease_quantity', methods: ['GET', 'POST'])]
    public function decreaseQuantity(Request $request, CartItemHelper $cartItemHelper, Product $product): JsonResponse
    {
        try {
            $session = $request->getSession();

            $cartItemHelper->decreaseQuantity($product, $session);

            return new JsonResponse([
                'type' => 'success',
                'message' => 'Product Quantity Decreased successfully!!!'
            ], 200);
        } catch (Exception $e) {
            return new JsonResponse([
                'type' => 'warning',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    #[Route('/{id}/buy/now', name: 'app_cart_item_buy_now', methods: ['GET', 'POST'])]
    public function buyNow(Request $request, CartItemHelper $cartItemHelper, Product $product): Response
    {
        try {
            $session = $request->getSession();

            $cartItemHelper->addToCart($product, $session);

            return $this->redirectToRoute('app_cart_show');
        } catch (Exception $e) {
            $this->addFlash('error', $e->getMessage());

            return $this->redirectToRoute('app_default');
        }
    }
}
