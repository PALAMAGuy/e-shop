<?php

namespace App\Controller;

use App\Entity\GroupeProduit;
use App\Form\GroupeProduitType;
use App\Repository\GroupeProduitRepository;
use App\Repository\TypeProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/groupe-produit')]
class GroupeProduitController extends AbstractController
{

    #[Route('/{id}', name: 'app_groupe_produit_show', methods: ['GET'])]
    public function show(GroupeProduit $groupeProduit,TypeProduitRepository $typeProduitRepository): Response
    {

        return $this->render('groupe_produit/show.html.twig', [
            'groupe_produit' => $groupeProduit,
            'type_produits' => $typeProduitRepository->findBy(['groupe'=>$groupeProduit->getId()]),

        ]);
    }

}
