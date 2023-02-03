<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Form\PanierType;
use App\Repository\PanierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MarqueRepository;
use App\Repository\ProduitRepository;
use App\Repository\PanierProduitRepository;
use App\Entity\PanierProduit;
use App\Form\PanierProduitType;

#[Route('/panier')]
class PanierController extends AbstractController
{
    
    #[Route('/{id}', name: 'app_panier_show', methods: ['GET'])]
    public function show(Request $request, Panier $panier,MarqueRepository $marqueRepository,ProduitRepository $produitRepository,PanierProduitRepository $panierProduitRepository): Response
    {
        $user = $this->getUser();
        
        if($user != $panier->getUserId()){

            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);

        }
        else{
            
            return $this->render('panier/show.html.twig', [
                'panier' => $panier,
                'panier_produits' => $panierProduitRepository->findBy(['panier' => $panier->getId()]),

            ]);
        }

    }

}
