<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;
    
    #[ORM\ManyToOne(targetEntity: Sweatshirt::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Sweatshirt $sweatshirt = null;
    
    #[ORM\Column(length: 20)]
    private ?string $status = 'pending';
    
    #[ORM\Column(type : 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;
    
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getSweatshirt(): ?Sweatshirt
    {
        return $this->sweatshirt;
    }

    public function setSweatshirt(Sweatshirt $sweatshirt): self
    {
        $this->sweatshirt = $sweatshirt;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
