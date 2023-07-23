<?php

namespace App\Controller;

use App\Entity\Vendor;
use App\Repository\VendorOrderRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vendor/order')]
#[Security("is_granted('ROLE_VENDOR')")]
class VendorOrderController extends AbstractController
{
    #[Route('/{id}', name: 'app_vendor_order_index', methods: ['GET'])]
    public function index(VendorOrderRepository $vendorOrderRepository, Vendor $vendor): Response
    {
        $vendorOrders  = $vendorOrderRepository->findBy(['vendor' => $vendor], ['createdAt' => 'DESC']);

        return $this->render('vendor_order/index.html.twig', [
            'vendor_orders' => $vendorOrders,
            'vendor' => $vendor
        ]);
    }
}
