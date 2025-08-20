<?php

namespace App\Controller;

use App\Entity\Sweatshirt;
use App\Entity\User;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\StripeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CheckoutController extends AbstractController
{
    #[Route('/checkout', name: 'checkout')]
    public function checkout(CartService $cartService, StripeService $stripeService): RedirectResponse
    {
        $cart = $cartService->getDetailedCart();
        $session = $stripeService->createCheckoutSessionFromCart($cart, $this->getUser());

        return $this->redirect($session->url);
    }

    #[Route('/checkout/success', name: 'checkout_success')]
    public function success(): Response
    {
        return $this->render('checkout/success.html.twig');
    }

    #[Route('/checkout/cancel', name: 'checkout_cancel')]
    public function cancel(): Response
    {
        return $this->render('checkout/cancel.html.twig');
    }

    #[Route('stripe/webhook', name: 'stripe_webhook', methods: ['POST'])]
    public function webhook(Request $request, EntityManagerInterface $em, OrderService $orderService): Response
    {
        $playload = $request->getContent();
        $event = json_decode($playload);

        if ($event && $event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            $sweatshirtId = $session->metadata->sweatshirtId;
            $userId = $session->metadata->userId;

            $sweatshirt = $em->getRepository(Sweatshirt::class)->find($sweatshirtId);
            $user = $em->getRepository(User::class)->find($userId);

            if($sweatshirt && $user) {
                $orderService->createOrder($sweatshirt, $user);
            }
        }

        return new Response();
    }
}
