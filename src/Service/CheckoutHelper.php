<?php

namespace App\Service;

use App\Entity\CartItem;
use Exception;
use Stripe\Checkout\Session as CheckoutSession;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CheckoutHelper
{
    public function __construct(
        private Security $security,
        private string $stripeApiKey,
        private UrlGeneratorInterface $urlGeneratorInterface
    ) {
    }

    public function getCheckoutSession(Session $session): CheckoutSession
    {
        $stripe = new \Stripe\StripeClient($this->stripeApiKey);

        return $stripe->checkout->sessions->create([
            'line_items' => $this->getLineItems($session),
            'mode' => 'payment',
            'automatic_tax' => [
                'enabled' => true,
            ],
            'billing_address_collection' => 'required',
            'success_url' => $this->urlGeneratorInterface->generate('app_checkout_success', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->urlGeneratorInterface->generate('app_checkout_failed', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);
    }

    private function getLineItems(Session $session): array
    {
        $cartItems = $session->get('cart')->getCartItems();

        return array_map(function (CartItem $cartItem) {
            return [
                'price_data' => [
                    'currency' => 'cad',
                    'product_data' => [
                        'name' => $cartItem->getProduct()->getName(),
                    ],
                    'unit_amount' => $cartItem->getProduct()->getPrice(),
                ],
                'quantity' => $cartItem->getQuantity(),
            ];
        }, $cartItems->getValues());
    }
}
