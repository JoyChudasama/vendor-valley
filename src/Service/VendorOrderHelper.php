<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Vendor;
use App\Entity\VendorOrder;
use App\Entity\VendorOrderInvoice;
use App\Entity\VendorOrderItem;
use App\Repository\VendorRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class VendorOrderHelper
{
    public function __construct(
        private VendorRepository $vendorRepository,
        private EntityManagerInterface $entityManagerInterface,
        private float $vendorValleyRate,
        private EmailHelper $emailHelper
    ) {
    }

    public function handleVendorOrders(Order $order): void
    {
        $orderItems = $order->getOrderItems()->getValues();
        $orderItemsByVendorId = [];
        foreach ($orderItems as $orderItem) {
            $vendorId = $orderItem->getProduct()->getVendor()->getId();
            $orderItemsByVendorId["$vendorId"][] = $orderItem;
        }

        foreach ($orderItemsByVendorId as $vendorId => $orderItems) {
            $vendor = $this->vendorRepository->find($vendorId);

            $this->createVendorOrder($order, $vendor, $orderItems);
            $this->entityManagerInterface->flush();
            $this->emailHelper->sendNewVendorOrderCreatedEmail($vendorOrder);
        }
    }

    private function createVendorOrder(Order $order, Vendor $vendor, array $orderItems): VendorOrder
    {
        $vendorOrder = new VendorOrder();
        $vendorOrder->setVendor($vendor);
        $vendorOrder->setOrderNumber($order->getOrderNumber());
        $subTotal = 0;

        foreach ($orderItems as $orderItem) {
            $vendorOrderItem = $this->createVendorOrderItem($orderItem, $vendorOrder);
            $vendorOrder->addVendorOrderItem($vendorOrderItem);
            $subTotal += $vendorOrderItem->getTotalAmount();
        }

        $vendorOrder->setSubTotal($subTotal);

        $this->createVendorOrderInvoice($vendorOrder);

        $vendor->addVendorOrder($vendorOrder);

        $this->entityManagerInterface->persist($vendorOrder);

        return $vendorOrder;
    }

    private function createVendorOrderItem(OrderItem $orderItem, VendorOrder $vendorOrder): VendorOrderItem
    {
        $vendorOrderItem = new VendorOrderItem();
        $vendorOrderItem->setProduct($orderItem->getProduct());
        $vendorOrderItem->setQuantity($orderItem->getQuantity());
        $vendorOrderItem->setVendorOrder($vendorOrder);

        return $vendorOrderItem;
    }

    private function createVendorOrderInvoice(VendorOrder $vendorOrder): VendorOrderInvoice
    {
        $vendorOrderInvoice = new VendorOrderInvoice();
        $vendorOrderInvoice->setVendorOrder($vendorOrder);

        $subTotal = $vendorOrder->getSubTotal();
        $federalTaxAmount = 0;
        $provincialTaxAmount = 0;
        $vendorValleyComissionAmount = ($this->vendorValleyRate / 100) * $subTotal;
        $grandTotal = $subTotal - $federalTaxAmount - $provincialTaxAmount - $vendorValleyComissionAmount;

        $vendorOrderInvoice->setSubTotal($subTotal);
        $vendorOrderInvoice->setFedTaxAmount($federalTaxAmount);
        $vendorOrderInvoice->setprovincialTaxAmount($provincialTaxAmount);
        $vendorOrderInvoice->setGrandTotal($grandTotal);
        $vendorOrderInvoice->setInvoiceNumber($this->createVendorOrderInvoiceNumber($vendorOrder));

        $vendorOrder->setVendorOrderInvoice($vendorOrderInvoice);

        return $vendorOrderInvoice;
    }

    private function createVendorOrderInvoiceNumber(VendorOrder $vendorOrder): string
    {
        $vendorOrderNumber = $vendorOrder->getOrderNumber();

        $randomNumber = rand(0, 60);

        $second = intval((new DateTime())->format('s'));

        $diff = $second - $randomNumber;

        if ($diff < 0) $diff += 60;

        $diffFormatted = str_pad($diff, 2, '0', STR_PAD_LEFT);

        return $vendorOrderNumber . $diffFormatted;
    }
}
