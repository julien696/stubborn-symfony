<?php

namespace App\Services;

use App\Entity\Sweatshirt;
use Doctrine\ORM\EntityManagerInterface;

class SweatshirtManager
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function saveSweatshirt(Sweatshirt $sweatshirt): void
    {
        $this->em->persist($sweatshirt);
        $this->em->flush();
    }

    public function deleteSweatshirt(Sweatshirt $sweatshirt): void
    {
        $this->em->remove($sweatshirt);
        $this->em->flush();
    }

}