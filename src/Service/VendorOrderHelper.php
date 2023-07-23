<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\VendorOrder;
use App\Entity\VendorOrderItem;
use App\Repository\VendorRepository;
use Doctrine\ORM\EntityManagerInterface;

class VendorOrderHelper
{
    public function __construct(
        private VendorRepository $vendorRepository,
        private EntityManagerInterface $entityManagerInterface,
        private float $vendorValleyRate
    ) {
    }

    public function createVendorOrders(Order $order): void
    {
        $orderItems = $order->getOrderItems()->getValues();
        $orderItemsByVendorId = [];
        foreach ($orderItems as $orderItem) {
            $vendorId = $orderItem->getProduct()->getVendor()->getId();
            $orderItemsByVendorId["$vendorId"][] = $orderItem;
        }

        foreach ($orderItemsByVendorId as $vendorId => $orderItems) {
            $vendor = $this->vendorRepository->find($vendorId);
            $totalAmount = 0;

            $vendorOrder = new VendorOrder();
            $vendorOrder->setVendor($vendor);
            $vendorOrder->setOrderNumber($order->getOrderNumber());

            foreach ($orderItems as $orderItem) {
                $vendorOrderItem = $this->createVendorOrderItem($orderItem, $vendorOrder);
                $vendorOrder->addVendorOrderItem($vendorOrderItem);
                $totalAmount += $vendorOrderItem->getTotalAmount();
            }
            
            $vendorOrder->setTotalAmount($totalAmount);

            $vendor->addVendorOrder($vendorOrder);

            $this->entityManagerInterface->persist($vendorOrder);
        }

        $this->entityManagerInterface->flush();
    }

    private function createVendorOrderItem(OrderItem $orderItem, VendorOrder $vendorOrder): VendorOrderItem
    {
        $vendorOrderItem = new VendorOrderItem();
        $vendorOrderItem->setProduct($orderItem->getProduct());
        $vendorOrderItem->setQuantity($orderItem->getQuantity());
        $vendorOrderItem->setVendorOrder($vendorOrder);

        return $vendorOrderItem;
    }
}
