<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SizeRepository;
use App\Entity\Sweatshirt;
use App\Form\Model\SweatshirtSizeStockData;
use App\Entity\SweatshirtSize;


class SweatshirtSizeFactory
{
    public function __construct(
        private EntityManagerInterface $em,
        private SizeRepository $sizeRepo
    ) {}

    public function createFromDTO(Sweatshirt $sweatshirt, SweatshirtSizeStockData $dto): void
    {
        foreach (['XS', 'S', 'M', 'L', 'XL'] as $label) {
            $stock = $dto->$label;

            if ($stock !== null && $stock > 0) {
                $size = $this->sizeRepo->findOneBy(['label' => $label]);
                if (!$size) {
                    throw new \RuntimeException("Taille '$label' introuvable.");
                }

                $sweatshirtSize = new SweatshirtSize();
                $sweatshirtSize->setSweatshirt($sweatshirt);
                $sweatshirtSize->setSize($size);
                $sweatshirtSize->setStock($stock);
                $this->em->persist($sweatshirtSize);
            }
        }

        $this->em->flush();
    }
}
