<?php

namespace App\Controller;

use App\Repository\VendorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default')]
    public function index(VendorRepository $vendorRepository): Response
    {
        $allVendors = [];
        // $allVendors = $vendorRepository->findAll();

        return $this->render('default/index.html.twig', [
            'vendors' => $allVendors
        ]);
    }
}
