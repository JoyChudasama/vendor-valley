<?php

namespace App\Service;

use App\Entity\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Session\Session;

class CartHelper extends AbstractController
{
    public function __construct(private Security $security)
    {
    }

    public function getCart(Session $session): Cart
    {
        $cart = $session->get('cart');
        if ($cart) return $cart;

        $cart = new Cart();
        $cart->setCustomer($this->security->getUser());
        $cart->setTotalAmount(0);

        $session->set('cart', $cart);

        return $cart;
    }

    public function clearCart(Session $session)
    {
        $session->remove('cart');
        $session->remove('cart_items');
    }
}
