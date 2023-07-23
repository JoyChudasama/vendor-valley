<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\User;
use Exception;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Transport\TransportInterface;

class EmailHelper
{
    public function __construct(
        private MailerInterface $mailerInterface,
        private string $vendorValleyEmail,
        private Security $security,
        private TransportInterface $transportInterface
    ) {
    }

    public function sendOrderPlacedEmail(Order $order)
    {
        $user = $this->security->getUser();
        $orderNumber = $order->getOrderNumber();
        $orderItems = count($order->getOrderItems());
        $subject = "Your VendorValley.com order #$orderNumber of $orderItems item/s";

        $email = $this->createOrderPlacedEmail($this->vendorValleyEmail, $user->getEmail(), $subject, $user, $order);

        try {
            $this->transportInterface->send($email);
        } catch (TransportExceptionInterface $e) {
            throw new Exception('Sorry something went wrong! Could not send order confirmation email.', 400);
        }
    }

    protected function createOrderPlacedEmail(string $from, string $to, string $subject, User $user, Order $order): TemplatedEmail
    {
        return (new TemplatedEmail())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->htmlTemplate('email/order_placed.html.twig')
            ->context([
                'user' => $user,
                'order' => $order
            ]);
    }
}