<?php

namespace App\Controller;

use App\Service\CheckoutHelper;
use App\Service\EmailHelper;
use App\Service\OrderHelper;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/checkout')]
class CheckoutController extends AbstractController
{
    #[Route('/', name: 'app_checkout')]
    public function checkout(Request $request, CheckoutHelper $checkoutHelper): Response
    {
        $session = $request->getSession();

        try {
            $checkout_session = $checkoutHelper->getCheckoutSession($session);
        } catch (Exception $e) {
            $this->addFlash('error', 'Something went wrong. Could not process the payment. Please try again.');
            return $this->redirectToRoute('app_cart_show');
        }

        return $this->redirect($checkout_session->url, 303);
    }

    #[Route('/checkout-success', name: 'app_checkout_success')]
    public function checkoutSuccess(Request $request, OrderHelper $orderHelper, EmailHelper $emailHelper): Response
    {
        $session = $request->getSession();
        $user = $this->getUser();

        $order = $orderHelper->createOrder($session);
        $emailHelper->sendOrderPlacedEmail($order);

        $session->remove('cart');

        $this->addFlash('success', 'Order placed successfully. You will recieve an order confirmation email shortly. Thank you for shopping with us.');

        return $this->redirectToRoute('app_order_index', ['id' => $user->getId()], 303);
    }

    #[Route('/checkout-failed', name: 'app_checkout_failed')]
    public function checkoutFailed(): Response
    {
        $this->addFlash('error', 'Something went wrong. Could not process the payment. Please try again.');
        return $this->redirectToRoute('app_cart_show', [], 303);
    }
}
