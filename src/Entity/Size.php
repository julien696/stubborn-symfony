<?php

namespace App\Entity;

use App\Repository\SizeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SizeRepository::class)]
class Size
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $label = null;

    /**
     * @var Collection<int, SweatshirtSize>
     */
    #[ORM\OneToMany(targetEntity: SweatshirtSize::class, mappedBy: 'size')]
    private Collection $sweatshirtSizes;

    public function __construct()
    {
        $this->sweatshirtSizes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, SweatshirtSize>
     */
    public function getSweatshirtSizes(): Collection
    {
        return $this->sweatshirtSizes;
    }

    public function addSweatshirtSize(SweatshirtSize $sweatshirtSize): static
    {
        if (!$this->sweatshirtSizes->contains($sweatshirtSize)) {
            $this->sweatshirtSizes->add($sweatshirtSize);
            $sweatshirtSize->setSize($this);
        }

        return $this;
    }

    public function removeSweatshirtSize(SweatshirtSize $sweatshirtSize): static
    {
        if ($this->sweatshirtSizes->removeElement($sweatshirtSize)) {
            // set the owning side to null (unless already changed)
            if ($sweatshirtSize->getSize() === $this) {
                $sweatshirtSize->setSize(null);
            }
        }

        return $this;
    }
}
