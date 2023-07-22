<?php

namespace App\Service;

use App\Entity\CartItem;
use App\Entity\Order;
use App\Entity\OrderItem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class OrderHelper
{
    public function __construct(private EntityManagerInterface $entityManagerInterface)
    {
    }

    public function createOrder(Session $session): void
    {
        $cart = $session->get('cart');
        $cartItems = $cart->getCartItems();

        $order = new Order();
        $order->setUserCustomer($cart->getUserCustomer());
        $order->setTotalAmount($cart->getTotalAmount());

        foreach ($cartItems as $cartItem) {
            $orderItem = $this->createOrderItem($cartItem, $order);
            $order->addOrderItem($orderItem);
        }
        // dd($order);
        
        $this->entityManagerInterface->persist($order);
        $this->entityManagerInterface->flush();
    }

    private function createOrderItem(CartItem $cartItem, Order $order): OrderItem
    {
        $orderItem = new OrderItem();
        $orderItem->setProduct($cartItem->getProduct());
        $orderItem->setQuantity($cartItem->getQuantity());
        $orderItem->setRelatedOrder($order);

        return $orderItem;
    }
}
