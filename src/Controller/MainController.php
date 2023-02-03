<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MarqueRepository;
use App\Repository\ProduitRepository;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(MarqueRepository $marqueRepository,ProduitRepository $produitRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'marques' => $marqueRepository->findBy([], ['name' => 'ASC']),
            'produits' => $produitRepository->findBy([], ['id' => 'DESC']),
        ]);
    }
}
