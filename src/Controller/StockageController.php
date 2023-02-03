<?php

namespace App\Controller;

use App\Entity\Stockage;
use App\Form\StockageType;
use App\Repository\StockageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/stockage')]
class StockageController extends AbstractController
{
    #[Route('/', name: 'app_stockage_index', methods: ['GET'])]
    public function index(StockageRepository $stockageRepository): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_main');
        }
        return $this->render('stockage/index.html.twig', [
            'stockages' => $stockageRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_stockage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StockageRepository $stockageRepository): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_main');
        }
        $stockage = new Stockage();
        $form = $this->createForm(StockageType::class, $stockage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $stockageRepository->save($stockage, true);

            return $this->redirectToRoute('app_stockage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('stockage/new.html.twig', [
            'stockage' => $stockage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stockage_show', methods: ['GET'])]
    public function show(Stockage $stockage): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_main');
        }
        return $this->render('stockage/show.html.twig', [
            'stockage' => $stockage,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_stockage_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Stockage $stockage, StockageRepository $stockageRepository): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_main');
        }
        $form = $this->createForm(StockageType::class, $stockage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $stockageRepository->save($stockage, true);

            return $this->redirectToRoute('app_stockage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('stockage/edit.html.twig', [
            'stockage' => $stockage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stockage_delete', methods: ['POST'])]
    public function delete(Request $request, Stockage $stockage, StockageRepository $stockageRepository): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_main');
        }
        if ($this->isCsrfTokenValid('delete'.$stockage->getId(), $request->request->get('_token'))) {
            $stockageRepository->remove($stockage, true);
        }

        return $this->redirectToRoute('app_stockage_index', [], Response::HTTP_SEE_OTHER);
    }
}
