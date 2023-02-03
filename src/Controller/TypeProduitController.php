<?php

namespace App\Controller;

use App\Entity\TypeProduit;
use App\Form\TypeProduitType;
use App\Repository\TypeProduitRepository;
use App\Repository\CategorieProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/type-produit')]
class TypeProduitController extends AbstractController
{
    #[Route('/', name: 'app_type_produit_index', methods: ['GET'])]
    public function index(TypeProduitRepository $typeProduitRepository): Response
    {
        return $this->render('type_produit/index.html.twig', [
            'type_produits' => $typeProduitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_type_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TypeProduitRepository $typeProduitRepository): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_main');
        }

        $typeProduit = new TypeProduit();
        $form = $this->createForm(TypeProduitType::class, $typeProduit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$typeProduitRepository->save($typeProduit, true);

            $file = $typeProduit->getPhoto(); 
            $fileName = md5(uniqid()).'.'.$file->guessExtension(); 
            $file->move($this->getParameter('photos_directory_type'), $fileName); 
            $typeProduit->setImg($fileName); 

            $typeProduitRepository->save($typeProduit, true);

            return $this->redirectToRoute('app_type_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_produit/new.html.twig', [
            'type_produit' => $typeProduit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_produit_show', methods: ['GET'])]
    public function show(TypeProduit $typeProduit,CategorieProduitRepository $categorieProduitRepository): Response
    {
        return $this->render('type_produit/show.html.twig', [
            'type_produit' => $typeProduit,
            'categorie_produits' => $categorieProduitRepository->findBy(['type'=>$typeProduit->getId()]),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_type_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeProduit $typeProduit, TypeProduitRepository $typeProduitRepository): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_main');
        }

        $form = $this->createForm(TypeProduitType::class, $typeProduit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeProduitRepository->save($typeProduit, true);

            return $this->redirectToRoute('app_type_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_produit/edit.html.twig', [
            'type_produit' => $typeProduit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_produit_delete', methods: ['POST'])]
    public function delete(Request $request, TypeProduit $typeProduit, TypeProduitRepository $typeProduitRepository): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_main');
        }

        if ($this->isCsrfTokenValid('delete'.$typeProduit->getId(), $request->request->get('_token'))) {
            $typeProduitRepository->remove($typeProduit, true);
        }

        return $this->redirectToRoute('app_type_produit_index', [], Response::HTTP_SEE_OTHER);
    }
}
