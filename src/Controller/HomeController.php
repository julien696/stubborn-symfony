<?php

namespace App\Controller;

use App\Repository\SweatshirtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(SweatshirtRepository $sweatshirtRepository): Response
    {

        $sweatshirtsTop = $sweatshirtRepository->findTop();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'sweatshirtsTop' => $sweatshirtsTop
        ]);
    }
}
