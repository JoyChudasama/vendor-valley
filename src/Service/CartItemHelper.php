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

        $isAlreadyAdded = $this->isCartItemAlreadyAdded($product, $session);

        if ($isAlreadyAdded) {
            $cartItem = $this->getCartItemFromProduct($product, $session);
            $cartItem->setQuantity($cartItem->getQuantity() + 1);

            return $cart->setTotalAmount($cart->getTotalAmount() + $cartItem->getProduct()->getPrice());
        }

        $cartItem = new CartItem();
        $cartItem->setProduct($product);

        $cart->addCartItem($cartItem);
        $cart->setTotalAmount($cart->getTotalAmount() + $cartItem->getProduct()->getPrice());
    }

    public function removeFromCart(Product $product, Session $session, bool $isRemovingAllQuantity)
    {
        try {
            $cart = $this->cartHelper->getCart($session);
            $cartItem = $this->getCartItemFromProduct($product, $session);
            $cart->removeCartItem($cartItem);

            if ($isRemovingAllQuantity) return $cart->setTotalAmount($cart->getTotalAmount() - ($product->getPrice() * $cartItem->getQuantity()));

            $cart->setTotalAmount($cart->getTotalAmount() - $product->getPrice());
        } catch (Exception $e) {
            return throw new Exception('Something went wrong. Try again');
        }
    }

    public function increaseQuantity(Product $product, Session $session)
    {
        try {
            $cart = $this->cartHelper->getCart($session);
            $cartItem = $this->getCartItemFromProduct($product, $session);
            $cartItem->setQuantity($cartItem->getQuantity() + 1);

            $cart->setTotalAmount($cart->getTotalAmount() + $product->getPrice());
        } catch (Exception $e) {
            return throw new Exception('Something went wrong. Try again');
        }
    }

    public function decreaseQuantity(Product $product, Session $session)
    {
        try {
            $cart = $this->cartHelper->getCart($session);
            $cartItem = $this->getCartItemFromProduct($product, $session);

            if ($cartItem->getQuantity() === 1) return  $this->removeFromCart($product, $session, false);

            $cartItem->setQuantity($cartItem->getQuantity() - 1);
            $cart->setTotalAmount($cart->getTotalAmount() - $product->getPrice());
        } catch (Exception $e) {
            return throw new Exception('Something went wrong. Try again');
        }
    }

    private function getCartItemFromProduct(Product $product, Session $session): ?CartItem
    {
        $cart = $this->cartHelper->getCart($session);

        foreach ($cart->getCartItems() as $cartItem) {
            if ($cartItem->getProduct()->getId() === $product->getId()) return $cartItem;
        }

        return null;
    }

    private function isCartItemAlreadyAdded(Product $product, Session $session): bool
    {
        $cartItem = $this->getCartItemFromProduct($product, $session);

        return $cartItem ? true : false;
    }
}
