<?php

namespace App\Controller;

use App\Entity\Sweatshirt;
use App\Form\SweatshirtType;
use App\Repository\SweatshirtRepository;
use App\Services\SweatshirtManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\Model\SweatshirtSizeStockData;
use App\Form\SweatshirtSizeStockType;
use App\Services\SweatshirtSizeFactory;


final class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin.index')]
    public function index(Request $request, SweatshirtRepository $sweatshirtRepository): Response
    {
        $sweatshirts = $sweatshirtRepository->findAll();

        $addSweatshirtForm = $this->createForm(SweatshirtType::class, new Sweatshirt(), [
            'action' => $this->generateUrl('admin.addSweatshirt'),
            'method' => 'POST',
        ]);

       $editSweatshirtForm = $this->createForm(SweatshirtType::class, new Sweatshirt());

        $selectedSweatshirt = null;
        $selectedId = $request->query->get('sweatshirt_id');

        if($selectedId) {
            $selectedSweatshirt = $sweatshirtRepository->find($selectedId);
            if($selectedSweatshirt) {
                 $editSweatshirtForm = $this->createForm(SweatshirtType::class, $selectedSweatshirt, [
                'action' => $this->generateUrl('admin.editSweatshirt', ['id' => $selectedId]),
                'method' => 'POST',
                ]);
            }
        }
       
        $stockDto = new SweatshirtSizeStockData();
        $addSweatshirtSizeForm = $this->createForm(SweatshirtSizeStockType::class, $stockDto, [
            'action' => $this->generateUrl('admin.addSweatshirtSize'),
            'method' => 'POST',
        ]);

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'addSweatshirtForm' => $addSweatshirtForm->createView(),
            'editSweatshirtForm' => $editSweatshirtForm->createView(),
            'addSweatshirtSizeForm' => $addSweatshirtSizeForm->createView(),
            'sweatshirts' => $sweatshirts,
            'selectedSweatshirt' => $selectedSweatshirt
        ]);
    }

    #[Route('admin/add/sweatshirt', name: 'admin.addSweatshirt', methods: ['POST'])]
    public function addSweatshirt(Request $request, SweatshirtManager $manager): Response
    {
        $sweatshirt = new Sweatshirt();
     
        $form = $this->createForm(SweatshirtType::class, $sweatshirt, [
            'action' => $this->generateUrl('admin.addSweatshirt'),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->saveSweatshirt($sweatshirt);
            $this->addFlash('success', 'Sweatshirt ajouté');
        }

        return $this->redirectToRoute('admin.index');
    }

   #[Route('admin/edit/sweatshirt', name: 'admin.editSweatshirt', methods: ['POST'])]
    public function editSweatshirt(Request $request, SweatshirtRepository $sweatshirtRepository, SweatshirtManager $manager): Response
    {
        $id = $request->request->get('sweatshirt_id');
        $sweatshirt = $sweatshirtRepository->find($id);

        if ($sweatshirt) {

            $form = $this->createForm(SweatshirtType::class, $sweatshirt, [
                'action' => $this->generateUrl('admin.editSweatshirt'),
                'method' => 'POST',
            ]);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {

                    $manager->saveSweatshirt($sweatshirt);
                    $this->addFlash('success', 'Sweatshirt ajouté');
                }
        }

        return $this->redirectToRoute('admin.index');
    }



    #[Route('admin/delete/sweatshirt', name: 'admin.deleteSweatshirt', methods: ['POST'])]
    public function deleteSweatshirt(Request $request, SweatshirtRepository $sweatshirtRepository, SweatshirtManager $manager): Response
    {
        $id = $request->request->get('sweatshirt_id');
        $sweatshirt = $sweatshirtRepository->find($id);

        if($sweatshirt) {
            $manager->deleteSweatshirt($sweatshirt);
            $this->addFlash('success', 'Sweatshirt supprimé');
        }

        return $this->redirectToRoute('admin.index');
    }

    #[Route('/admin/add/sweatshirtsize', name: 'admin.addSweatshirtSize', methods: ['POST'])]
    public function addSweatshirtSize(
        Request $request, SweatshirtRepository $sweatshirtRepository, SweatshirtSizeFactory $factory): Response 
    {

        $id = $request->request->get('sweatshirt_id');
        $sweatshirt = $sweatshirtRepository->find($id);
        $dto = new SweatshirtSizeStockData();

        $form = $this->createForm(SweatshirtSizeStockType::class, $dto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $factory->createFromDTO($sweatshirt, $dto);
            $this->addFlash('success', 'Tailles ajoutées avec succès');
        }

        return $this->redirectToRoute('admin.index');
    }

}
