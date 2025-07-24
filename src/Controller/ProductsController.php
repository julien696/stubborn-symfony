<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductsController extends AbstractController
{
    #[Route('/products', name: 'products')]
    public function index(): Response
    {
        return $this->render('products/index.html.twig', [
            'controller_name' => 'ProductsController',
        ]);
    }


     #[Route('/product/{id}', name: 'product')]
    public function show(int $id): Response
    {
        return $this->render('products/show.html.twig', [
            'controller_name' => 'ProductController',
            'id' => $id,
        ]);
    }
}
