<?php

namespace App\Service;

use App\Entity\CartItem;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Session\Session;

class OrderHelper
{
    public function __construct(
        private EntityManagerInterface $entityManagerInterface,
        private Security $security,
        private ProductRepository $productRepository
    ) {
    }

    public function createOrder(Session $session): Order
    {
        $cart = $session->get('cart');
        $cartItems = $cart->getCartItems();
        $user = $this->security->getUser();

        $order = new Order();
        $order->setUser($user);
        $order->setTotalAmount($cart->getTotalAmount());
        $order->setOrderNumber($this->createOrderNumber());
        foreach ($cartItems as $cartItem) {
            $orderItem = $this->createOrderItem($cartItem, $order);
            $order->addOrderItem($orderItem);
        }

        $user->addOrder($order);

        $this->entityManagerInterface->persist($order);
        $this->entityManagerInterface->flush();

        return $order;
    }

    private function createOrderItem(CartItem $cartItem, Order $order): OrderItem
    {
        $orderItem = new OrderItem();

        // Need to find fix this. Not sure if entity relation is wrong with Product. 
        $product = $cartItem->getProduct();
        $product = $this->productRepository->find($product->getId());

        $orderItem->setProduct($product);
        $orderItem->setQuantity($cartItem->getQuantity());
        $orderItem->setRelatedOrder($order);

        return $orderItem;
    }

    private function createOrderNumber(): string
    {
        $dateTime = new \DateTime();
        $orderNumber = $dateTime->format('YmdHisu');

        return $orderNumber;
    }
}
