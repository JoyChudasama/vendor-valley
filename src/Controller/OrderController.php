<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/order')]
class OrderController extends AbstractController
{
    #[Route('/{id}', name: 'app_order_index', methods: ['GET'])]
    public function index(OrderRepository $orderRepository, User $user): Response
    {
        $orders = $orderRepository->findBy(['user' => $user], ['createdAt' => 'DESC']);

        return $this->render('order/index.html.twig', [
            'orders' => $orders
        ]);
    }
}
