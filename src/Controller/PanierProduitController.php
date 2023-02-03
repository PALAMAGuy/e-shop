<?php

namespace App\Controller;

use App\Entity\PanierProduit;
use App\Form\PanierProduitType;
use App\Repository\PanierProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PanierRepository;

#[Route('/panier-produit')]
class PanierProduitController extends AbstractController
{
    #[Route('/', name: 'app_panier_produit_index', methods: ['GET'])]
    public function index(PanierProduitRepository $panierProduitRepository): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_main');
        }

        return $this->render('panier_produit/index.html.twig', [
            'panier_produits' => $panierProduitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_panier_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PanierProduitRepository $panierProduitRepository): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_main');
        }

        $panierProduit = new PanierProduit();
        $form = $this->createForm(PanierProduitType::class, $panierProduit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $panierProduitRepository->save($panierProduit, true);

            return $this->redirectToRoute('app_panier_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('panier_produit/new.html.twig', [
            'panier_produit' => $panierProduit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_panier_produit_show', methods: ['GET'])]
    public function show(PanierProduit $panierProduit): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_main');
        }
        
        return $this->render('panier_produit/show.html.twig', [
            'panier_produit' => $panierProduit,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_panier_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PanierProduit $panierProduit, PanierProduitRepository $panierProduitRepository): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_main');
        }
        
        $form = $this->createForm(PanierProduitType::class, $panierProduit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $panierProduitRepository->save($panierProduit, true);

            return $this->redirectToRoute('app_panier_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('panier_produit/edit.html.twig', [
            'panier_produit' => $panierProduit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_panier_produit_delete', methods: ['POST'])]
    public function delete(Request $request, PanierProduit $panierProduit, PanierProduitRepository $panierProduitRepository): Response
    {

        if ($this->isCsrfTokenValid('delete'.$panierProduit->getId(), $request->request->get('_token'))) {
            $panierProduitRepository->remove($panierProduit, true);
        }

        //return $this->redirectToRoute('app_panier_produit_index', [], Response::HTTP_SEE_OTHER);
        return $this->redirect('/panier/'.$panierProduit->getPanier()->getId());

    }

    #[Route('/{id}/add', name: 'app_panier_produit_add', methods: ['POST'])]
    public function add(Request $request, PanierProduit $panierProduit, PanierProduitRepository $panierProduitRepository): Response
    {
        $quantity = $_REQUEST['quantity'];

        $panierProduit->setQuantity($quantity);
        $panierProduitRepository->save($panierProduit, true);

        return $this->redirect('/panier/'.$panierProduit->getPanier()->getId());

    }

}
