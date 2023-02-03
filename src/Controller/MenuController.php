<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\GroupeProduitRepository;
use App\Repository\PanierProduitRepository;
use App\Entity\PanierProduit;
use App\Repository\PanierRepository;
use App\Entity\Panier;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;

class MenuController extends AbstractController
{
    #[Route('/menu', name: 'app_menu')]

    public function index(GroupeProduitRepository $groupeProduitRepository): Response
    {
        return $this->render('menu/index.html.twig', [

            'controller_name' => 'MenuController',
            'groupe_produits' => $groupeProduitRepository->findAll()

        ]);
    }

    public function btnList(GroupeProduitRepository $groupeProduitRepository): Response
    {
        return $this->render('menu/btnlist.html.twig', [

            'controller_name' => 'MenuController',
            'groupe_produits' => $groupeProduitRepository->findAll()

        ]);
    }

    public function panier(): Response
    {
        return $this->render('menu/panier.html.twig', [

            'controller_name' => 'MenuController'

        ]);
    }

    #[Route('/hasPanier', name: 'app_panier_test_show', methods: ['GET'])]
    public function hasPanier(PanierRepository $panierRepository,AuthenticationUtils $authenticationUtils): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }
        else{
            $user = $this->getUser();
       
            $panier = $panierRepository->findBy(['user_id'=>$user]);

            if($panier){
                
                foreach($panier as $panier){

                    return $this->redirect('/panier/'.$panier->getId());

                }

            }else{

                return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);


            }
        }

    }

}
