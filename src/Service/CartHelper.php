<?php

namespace App\Service;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Session\Session;

class CartHelper
{
    public function __construct(private ProductRepository $productRepository, private Security $security)
    {
    }

    public function createNew(Session $session):Cart
    {
        $cartItems = $session->get('cart_items', []);
        $cart = new Cart();
        
        foreach ($cartItems as $cartItem) {
            $cart->addCartItem($cartItem);    
        }

        return $cart;
    }
}
