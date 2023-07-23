<?php

namespace App\Service;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Order;
use App\Entity\OrderInvoice;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\ProductRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Session\Session;

class OrderHelper
{
    public function __construct(
        private EntityManagerInterface $entityManagerInterface,
        private Security $security,
        private ProductRepository $productRepository,
        private float $federalTaxRate,
        private float $provincialTaxRate,
        private EmailHelper $emailHelper
    ) {
    }

    public function handleOrder(Session $session): Order
    {
        $cart = $session->get('cart');

        $this->updateProductQuantity($cart);

        $user = $this->security->getUser();
        $order = $this->createOrder($cart, $user);

        $user->addOrder($order);

        $this->entityManagerInterface->persist($order);
        $this->entityManagerInterface->flush();

        $this->emailHelper->sendOrderPlacedEmail($order);

        return $order;
    }

    private function createOrder(Cart $cart, User $user): Order
    {
        $order = new Order();
        $order->setUser($user);
        $order->setOrderNumber($this->createOrderNumber());
        $order->setSubTotal($cart->getTotalAmount());

        $cartItems = $cart->getCartItems();

        foreach ($cartItems as $cartItem) {
            $this->createOrderItem($cartItem, $order);
        }

        $this->createOrderInvoice($order);

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

        $order->addOrderItem($orderItem);

        return $orderItem;
    }

    private function createOrderNumber(): string
    {
        $dateTime = new \DateTime();
        $orderNumber = $dateTime->format('YmdHisu');

        return $orderNumber;
    }

    private function createOrderInvoice(Order $order): OrderInvoice
    {
        $orderInvoice = new OrderInvoice();
        $orderInvoice->setRelatedOrder($order);

        $subTotal = $order->getSubTotal();
        $federalTaxAmount = ($this->federalTaxRate / 100) * $subTotal;
        $provincialTaxAmount = ($this->provincialTaxRate / 100) * $subTotal;
        $grandTotal = $subTotal + $federalTaxAmount + $provincialTaxAmount;

        $orderInvoice->setSubTotal($subTotal);
        $orderInvoice->setFedTaxAmount($federalTaxAmount);
        $orderInvoice->setprovincialTaxAmount($provincialTaxAmount);
        $orderInvoice->setGrandTotal($grandTotal);
        $orderInvoice->setInvoiceNumber($this->createOrderInvoiceNumber());

        $order->setOrderInvoice($orderInvoice);

        return $orderInvoice;
    }

    private function createOrderInvoiceNumber(): string
    {
        $orderNumber = $this->createOrderNumber();

        $randomNumber = rand(0, 60);

        $second = intval((new DateTime())->format('s'));

        $diff = $second - $randomNumber;

        if ($diff < 0) $diff += 60;

        $diffFormatted = str_pad($diff, 2, '0', STR_PAD_LEFT);

        return $orderNumber . $diffFormatted;
    }

    private function updateProductQuantity(Cart $cart): void
    {
        $cartItems = $cart->getCartItems();
        
        foreach ($cartItems as $cartItem) {
            $product = $cartItem->getProduct();
            $product = $this->productRepository->find($product->getId());

            $product->setAvailableUnits($product->getAvailableUnits() - $cartItem->getQuantity());

            if ($product->getAvailableUnits() <= 0) $product->setIsAvailable(false);

            $this->entityManagerInterface->flush();
        }

    }
}
