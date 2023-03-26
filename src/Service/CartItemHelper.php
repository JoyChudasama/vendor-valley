<?php

namespace App\Service;

use App\Entity\CartItem;
use App\Entity\Product;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Session\Session;

class CartItemHelper
{
    public function __construct(private Security $security, private CartHelper $cartHelper)
    {
    }

    public function addToCart(Product $product, Session $session)
    {
        $user = $this->security->getUser();

        if (!$user) return throw new Exception('Please login');

        $cart = $this->cartHelper->getCart($session);

        $cartItems = $session->get('cart_items', []);

        $isAlreadyAdded = $cartItems && array_key_exists($product->getId(), $cartItems);

        if ($isAlreadyAdded) {

            $sessionCartItem = $cartItems[$product->getId()];
            $sessionCartItem->setQuantity($sessionCartItem->getQuantity() + 1);
            $cart->setTotalAmount($sessionCartItem->getQuantity() * $sessionCartItem->getProduct()->getPrice());

            return;
        }

        $cartItem = new CartItem();
        $cartItem->setProduct($product);
        $cartItems[$product->getId()] = $cartItem;

        $session->set('cart_items', $cartItems);

        $cart->addCartItem($cartItem);
    }

    public function removeFromCart(CartItem $cartItem, Session $session)
    {
        $cart = $this->cartHelper->getCart($session);
        $cart->removeCartItem($cartItem);

        $cartItems = $session->get('cart_items', []);
        unset($cartItems[$session->$cartItem->getProduct()->getId()]);
    }
}
