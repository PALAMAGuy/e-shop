<?php

namespace App\Controller;

use App\Entity\CommandeProduit;
use App\Form\CommandeProduitType;
use App\Repository\CommandeProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commande/produit')]
class CommandeProduitController extends AbstractController
{
    /*
    #[Route('/', name: 'app_commande_produit_index', methods: ['GET'])]
    public function index(CommandeProduitRepository $commandeProduitRepository): Response
    {
        return $this->render('commande_produit/index.html.twig', [
            'commande_produits' => $commandeProduitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_commande_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CommandeProduitRepository $commandeProduitRepository): Response
    {
        $commandeProduit = new CommandeProduit();
        $form = $this->createForm(CommandeProduitType::class, $commandeProduit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commandeProduitRepository->save($commandeProduit, true);

            return $this->redirectToRoute('app_commande_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande_produit/new.html.twig', [
            'commande_produit' => $commandeProduit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commande_produit_show', methods: ['GET'])]
    public function show(CommandeProduit $commandeProduit): Response
    {
        return $this->render('commande_produit/show.html.twig', [
            'commande_produit' => $commandeProduit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commande_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CommandeProduit $commandeProduit, CommandeProduitRepository $commandeProduitRepository): Response
    {
        $form = $this->createForm(CommandeProduitType::class, $commandeProduit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commandeProduitRepository->save($commandeProduit, true);

            return $this->redirectToRoute('app_commande_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande_produit/edit.html.twig', [
            'commande_produit' => $commandeProduit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commande_produit_delete', methods: ['POST'])]
    public function delete(Request $request, CommandeProduit $commandeProduit, CommandeProduitRepository $commandeProduitRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commandeProduit->getId(), $request->request->get('_token'))) {
            $commandeProduitRepository->remove($commandeProduit, true);
        }

        return $this->redirectToRoute('app_commande_produit_index', [], Response::HTTP_SEE_OTHER);
    }
    */
}
