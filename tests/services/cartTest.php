<?php

namespace App\Tests\Services;

use App\Entity\SweatshirtSize;
use App\Services\CartService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CartTest extends TestCase
{
    private $session;
    private $em;
    private $requestStack;

    protected function setUp(): void
    {
        $this->session = $this->createMock(SessionInterface::class);

        $this->requestStack = $this->createMock(RequestStack::class);
        $this->requestStack->method('getSession')->willReturn($this->session);

        $this->em = $this->createMock(EntityManagerInterface::class);
    }

    public function testAddItem(): void
    {
        $cartService = new CartService($this->requestStack, $this->em);

        $sweatshirtSize = $this->createMock(SweatshirtSize::class);
        $sweatshirtSize->method('getId')->willReturn(1);

        $this->session->method('get')->with('cart', [])->willReturn([]);

        $this->session->expects($this->once())
            ->method('set')
            ->with('cart', [
                1 => [
                    'sweatshirtSize' => 1,
                    'quantity' => 2
                ]
            ]);

        $cartService->addItem($sweatshirtSize, 2);
    }

    public function testRemoveItemById(): void
    {
        $cartService = new CartService($this->requestStack, $this->em);

        $cart = [
            1 => ['sweatshirtSize' => 1, 'quantity' => 2],
            2 => ['sweatshirtSize' => 2, 'quantity' => 1]
        ];

        $this->session->method('get')->with('cart', [])->willReturn($cart);

        $this->session->expects($this->once())
            ->method('set')
            ->with('cart', [
                2 => ['sweatshirtSize' => 2, 'quantity' => 1]
            ]);

        $cartService->removeItemById(1);
    }

    public function testRemoveItems(): void
    {
        $cartService = new CartService($this->requestStack, $this->em);

        $this->session->expects($this->once())
            ->method('remove')
            ->with('cart');

        $cartService->removeItems();
    }
}
