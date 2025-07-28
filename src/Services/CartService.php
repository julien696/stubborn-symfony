<?php

namespace App\Services;

use App\Entity\SweatshirtSize;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    private $session;

    public function __construct(RequestStack $requestStack)
    {
        $this->session = $requestStack->getSession();
    }

    public function addItem(SweatshirtSize $sweatshirtSize, int $quantity): void
    {
        $cart = $this->session->get('cart', []);
        $id = $sweatshirtSize->getId();

        if(isset($card[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'sweatshirtSize' => $id,
                'quantity' => $quantity
            ];
        }

        $this->session->set('cart', $cart);
    }

    public function getItems(): array
    {
        return $this->session->get('cart', []);
    }

    public function removeItems(): void
    {
        $this->session->remove('cart');
    }

    public function removeItemById(int $id): void
    {
        $cart = $this->session->get('cart', []);

        if( isset($cart[$id])) {
            unset($cart[$id]);
            $this->session->set('cart', []);
        }
    }

}