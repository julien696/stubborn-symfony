<?php

namespace App\Services;

use App\Entity\Order;
use App\Entity\Sweatshirt;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class OrderService
{
    public function __construct(private EntityManagerInterface $em) {}

    public function createOrder(User $user, Sweatshirt $sweatshirt): Order
    {
        $order = new Order();
        $order->setUser($user);
        $order->setSweatshirt($sweatshirt);
        $order->setStatus('paid');

        $this->em->persist($order);
        $this->em->flush();

        return $order;
    }
}