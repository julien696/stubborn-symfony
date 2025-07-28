<?php

namespace App\Controller;

use App\Entity\Sweatshirt;
use App\Form\ChooseYourSizeForSweatwhirtType;
use App\Repository\SweatshirtRepository;
use App\Repository\SweatshirtSizeRepository;
use App\Services\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CartController extends AbstractController
{
    #[Route('/cart/add/sweatshirt/{id}', name: 'cart_add_sweatshirt', methods: ['POST'])]
    public function addSweatshirtToCart(
    Request $request, 
    CartService $cartService,
    SweatshirtRepository $sweatshirtRepository,
    SweatshirtSizeRepository $sweatshirtSizeRepository,
    Sweatshirt $sweatshirt
    ): Response
    {
        $availableSizes = $sweatshirtSizeRepository->findAvailablesSizesForSweatshirt($sweatshirt);
        $form = $this->createForm(ChooseYourSizeForSweatwhirtType::class, null, [
            'available_sizes' => $availableSizes
        ]);
        $form->handleRequest($request);
       
        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $sweatshirtSize = $data->sweatshirtSize;
            $quantity = $data->quantity;

        $cartService->addItem($sweatshirtSize, $quantity);
        $this->addFlash('success', 'Sweatshirt ajouter au panier');
        return $this->redirectToRoute('products.index');
        }

        $this->addFlash('error', 'Erreur lors de l\'ajout au panier');
        $sweatshirts = $sweatshirtRepository->findAll();
        return $this->render('products/index.html.twig',[
            'sweatshirts' => $sweatshirts
        ]);
    }

    #[Route('/cart', name: 'cart.index')]
    public function index(CartService $cartService, SweatshirtSizeRepository $sweatshirtSizeRepository): Response
    {
        $cart = $cartService->getItems();
        $cartWithObjects = [];

        foreach ($cart as $item) {
            $sweatshirtSize = $sweatshirtSizeRepository->find($item['sweatshirtSize']);
            if ($sweatshirtSize) {
                $cartWithObjects[] = [
                    'sweatshirtSize' => $sweatshirtSize,
                    'quantity' => $item['quantity']
                ];
            }
        }

        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'cart' => $cartWithObjects
        ]);
    }

    #[Route('cart/remove/{id}', name:'cart.remove')]
    public function remove(int $id, CartService $cartService): Response
    {
        $cartService->removeItemById($id);
        return $this->redirectToRoute('cart.index');
    }
}
