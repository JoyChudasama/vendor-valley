<?php

namespace App\Controller;

use App\Form\CartType;
use App\Form\CheckoutType;
use App\Service\CartHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart')]
class CartController extends AbstractController
{

    #[Route('/number-of-items', name: 'app_cart_number_of_items', methods: ['GET'])]
    public function numberOfItems(Request $request): JsonResponse
    {
        $session = $request->getSession();

        $cart = $session->get('cart', []);

        $cartItems = empty($cart) ? 0 : count($cart->getCartItems());

        return new JsonResponse(['numberOfItems' => $cartItems], 200);
    }

    #[Route('/show', name: 'app_cart_show', methods: ['GET'])]
    public function show(Request $request, CartHelper $cartHelper): Response
    {
        $session = $request->getSession();

        $cart = $cartHelper->getCart($session);
        $isCartEmpty = count($cart->getCartItems()->getValues()) === 0;

        $form = $this->createForm(CartType::class, $cart);
        $checkoutForm = $this->createForm(CheckoutType::class, null, [
            'action'=>$this->generateUrl('app_checkout')
        ]);
        $template = $request->isXmlHttpRequest() ? 'cart/_form.html.twig' : 'cart/show.html.twig';

        return $this->render($template, [
            'cart' => $cart,
            'form' => $form->createView(),
            'is_cart_empty' => $isCartEmpty,
            'checkout_form'=>$checkoutForm->createView()
        ]);
    }

    #[Route('/clear', name: 'app_cart_clear', methods: ['GET'])]
    public function clear(Request $request, CartHelper $cartHelper): Response
    {
        $session = $request->getSession();
        $cartHelper->clearCart($session);

        return new JsonResponse([
            'type' => 'success',
            'message' => 'Cart cleared successfully!!!',
            'cart' => [
                'numberOfItems' => 0,
            ]
        ], 200);
    }
}
