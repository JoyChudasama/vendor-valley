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

            $cartItemHelper->createNew($product, $session);

            $cartItems = $session->get('cart_items', []);

            return new JsonResponse([
                'type' => 'success',
                'message' => 'Product Added to cart successfully!!!',
                'cart' => [
                    'numberOfItems' => count($cartItems),
                ]

            ], 200);
        } catch (Exception $e) {

            return new JsonResponse([
                'type' => 'warning',
                'message' => $e->getMessage()
            ], 400);
        }
    }

}
