<?php

namespace App\Controller;

use App\Entity\Sweatshirt;
use App\Form\ChooseYourSizeForSweatwhirtType;
use App\Repository\SweatshirtRepository;
use App\Repository\SweatshirtSizeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductsController extends AbstractController
{
    #[Route('/products', name: 'products.index')]
    public function index(SweatshirtRepository $sweatshirtRepository): Response
    {
        $sweatshirts = $sweatshirtRepository->findAll();
        return $this->render('products/index.html.twig', [
            'controller_name' => 'ProductsController',
            'sweatshirts' => $sweatshirts
        ]);
    }


     #[Route('/product/{id}', name: 'product.show')]
    public function show(Sweatshirt $sweatshirt, SweatshirtSizeRepository $sweatshirtRepository): Response
    {
        $availableSizes = $sweatshirtRepository->findAvailablesSizesForSweatshirt($sweatshirt);
        $form = $this->createForm(ChooseYourSizeForSweatwhirtType::class,null,[
            'available_sizes' => $availableSizes,
            'action' => $this->generateUrl('cart_add_sweatshirt', ['id' => $sweatshirt->getId()]),
            'method' => 'POST'
        ]);

        return $this->render('products/show.html.twig', [
            'controller_name' => 'ProductController',
            'sweatshirt' => $sweatshirt,
            'form' => $form->createView()
        ]);
    }
}
