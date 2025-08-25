<?php 

namespace App\Services;

use App\Entity\User;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class StripeService
{
    public function __construct(private string $stripeSecretKey, private UrlGeneratorInterface $router)
    {
        Stripe::setApiKey($stripeSecretKey);
    }

    public function createCheckoutSessionFromCart(array $cart, ?User $user): ?Session
    {
        if(empty($cart) || !$user) {
            return null;
        }

        $lineItems = [];

        foreach($cart as $item) {
            $sweatshirtSize = $item['sweatshirtSize'];
            $quantity = $item['quantity'];

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $sweatshirtSize->getSweatshirt()->getName() . '- Taille' . $sweatshirtSize->getSize()->getLabel(), 
                    ],
                    'unit_amount' => $sweatshirtSize->getSweatshirt()->getPrice() * 100,
                ],
                'quantity' => $quantity
            ];
        }
        try {
            return Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => 'http://localhost:8000' . $this->router->generate('checkout_success'),
                'cancel_url' => 'http://localhost:8000' . $this->router->generate('checkout_cancel'),
                'metadata' => [
                    'userId' => $user->getId(),
                ],
            ]);
        } catch (\Exception $e) {
            return null;
        }
    }
}