<?php

namespace App\Service;

use App\Entity\CartItem;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Session\Session;

class CartItemHelper
{
    public function __construct(private ProductRepository $productRepository, private Security $security)
    {
    }

    public function createNew(Product $product, Session $session)
    {
        $user = $this->security->getUser();

        if (!$user) return throw new Exception('Please login');

        $cartItem = new CartItem();
        $cartItem->setProduct($product);

        $cartItems = $session->get('cart_items', []);
        $cartItems[] = $cartItem;
        $session->set('cart_items', $cartItems);
    }
}
