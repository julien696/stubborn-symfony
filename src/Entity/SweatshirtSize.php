<?php

namespace App\Entity;

use App\Repository\SweatshirtSizeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SweatshirtSizeRepository::class)]
class SweatshirtSize
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\ManyToOne(inversedBy: 'sweatshirtSizes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Sweatshirt $sweatshirt = null;

    #[ORM\ManyToOne(inversedBy: 'sweatshirtSizes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Size $size = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function getSweatshirt(): ?Sweatshirt
    {
        return $this->sweatshirt;
    }

    public function setSweatshirt(?Sweatshirt $sweatshirt): static
    {
        $this->sweatshirt = $sweatshirt;

        return $this;
    }

    public function getSize(): ?Size
    {
        return $this->size;
    }

    public function setSize(?Size $size): static
    {
        $this->size = $size;

        return $this;
    }
}
