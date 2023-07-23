<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\VendorOrder;
use App\Repository\VendorRepository;

class VendorOrderHelper
{
    public function __construct(private VendorRepository $vendorRepository)
    {
    }

    public function createVendorOrder(Order $order): void
    {
        $orderItems = $order->getOrderItems()->getValues();
        $orderItemsByVendorId = [];

        foreach ($orderItems as  $orderItem) {
            $vendorId = $orderItem->getProduct()->getVendor()->getId();
            $orderItemsByVendor[$vendorId][] = $orderItem;
        }

        foreach ($orderItemsByVendorId as $vendorId => $orderItems) {
            $vendor = $this->vendorRepository->find($vendorId);

            $vendorOrder = new VendorOrder();
            $vendorOrder->setVendor($vendor);

            foreach ($orderItems as $orderItem) {
                $vendorOrder->addProduct($orderItem->getProduct());
            }
            dd('Will need VendorOrderItem entity cause of quantity missing from vendorOrder');


            $vendor->addVendorOrder($vendorOrder);
        }
    }
}
