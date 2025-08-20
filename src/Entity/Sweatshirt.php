<?php

namespace App\Entity;

use App\Repository\SweatshirtRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SweatshirtRepository::class)]
#[Vich\Uploadable()]
class Sweatshirt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(nullable: true)]
    private ?bool $top = null;

    #[ORM\Column(nullable:true)]
    private ?string $imageName = null;

    #[Vich\UploadableField(mapping: 'sweatshirts', fileNameProperty: 'imageName')]
    #[Assert\Image()]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $stripeProductId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $stripePriceId = null;


    /**
     * @var Collection<int, SweatshirtSize>
     */
    #[ORM\OneToMany(targetEntity: SweatshirtSize::class, mappedBy: 'sweatshirt', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $sweatshirtSizes;


    public function __construct()
    {
        $this->sweatshirtSizes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function isTop(): ?bool
    {
        return $this->top;
    }

    public function setTop(?bool $top): static
    {
        $this->top = $top;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): static
    {
        $this->imageName = $imageName;
        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile): static
    {
        $this->imageFile = $imageFile;

        if ($imageFile !== null) {
            $this->updatedAt = new \DateTimeImmutable();
        }
        
        return $this;
    }
    
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getStripeProductId(): ?string
    {
        return $this->stripeProductId;
    }

    public function setStripeProductId(?string $stripeProductId): self
    {
        $this->stripeProductId = $stripeProductId;
        return $this;
    }

    public function getStripePriceId(): ?string
    {
        return $this->stripePriceId;
    }

    public function setStripePriceId(?string $stripePriceId): self
    {
        $this->stripePriceId = $stripePriceId;
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
            $sweatshirtSize->setSweatshirt($this);
        }

        return $this;
    }

    public function removeSweatshirtSize(SweatshirtSize $sweatshirtSize): static
    {
        if ($this->sweatshirtSizes->removeElement($sweatshirtSize)) {
            if ($sweatshirtSize->getSweatshirt() === $this) {
                $sweatshirtSize->setSweatshirt(null);
            }
        }

        return $this;
    }

}
