<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\PanierProduit;
use App\Form\PanierProduitType;
use App\Repository\PanierProduitRepository;
use App\Repository\PanierRepository;
use App\Entity\Panier;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/produit')]
class ProduitController extends AbstractController
{
    #[Route('/', name: 'app_produit_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository,EntityManagerInterface $em): Response
    {

        $produits = $produitRepository->findAll();
        $research = null;

        if(isset($_REQUEST['search-bar'])){

            $research = $_REQUEST['search-bar'];

            $produits = $em->getRepository(Produit::class)->createQueryBuilder('o')
            ->andWhere('o.name LIKE :research')
            ->setParameter('research', '%'. $research . '%')
            ->getQuery()
            ->getResult();

            //$produits = $produitRepository->findBy(['name LIKE'=>"%" . $research . "%"]);
        }

        return $this->render('produit/index.html.twig', [
            'produits' => $produits,
            'research' => $research

        ]);
    }

    #[Route('/new', name: 'app_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProduitRepository $produitRepository): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_main');
        }

        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$produitRepository->save($produit, true);

            $file = $produit->getPhoto(); 
            $fileName = md5(uniqid()).'.'.$file->guessExtension(); 
            $file->move($this->getParameter('photos_directory_produit'), $fileName); 
            $produit->setImg($fileName); 

            $produitRepository->save($produit, true);

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produit_show', methods:  ['GET', 'POST'])]
    public function show(PanierRepository $panierRepository,Produit $produit,Request $request, PanierProduitRepository $panierProduitRepository): Response
    {
        $panierProduit = new PanierProduit();
        $form = $this->createForm(PanierProduitType::class, $panierProduit);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
  
            $user = $this->getUser();
            $panier = $panierRepository->findBy(['user_id'=>$user]);

            foreach($panier as $panier){

                $id_panier = $panier;

            }

            $panierProduit->setArticle($produit);
            $panierProduit->setPanier($id_panier);

            $panierProduitRepository->save($panierProduit, true);

            return $this->redirect('/panier/'.$id_panier->getId());

        }
        
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
            'panier_produit' => $panierProduit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_main');
        }

        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produitRepository->save($produit, true);

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produit_delete', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_main');
        }
        
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $produitRepository->remove($produit, true);
        }

        return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
    }
    
    #[Route('/{id}/addOne', name: 'app_panier_produit_addOne', methods: ['POST'])]
    public function addOne(Request $request, Produit $produit, PanierProduitRepository $panierProduitRepository,PanierRepository $panierRepository): Response
    {

        $user = $this->getUser();
       
        $panier = $panierRepository->findBy(['user_id'=>$user]);

        if($panier){
            
            foreach($panier as $panier){

                $id_panier = $panier;

            }
    
            $panierProduit = new PanierProduit();
            $panierProduit->setQuantity(1);
            $panierProduit->setPanier($id_panier);
            $panierProduit->setArticle($produit);
            $panierProduitRepository->save($panierProduit, true);

            return $this->redirect('/panier/'.$panier->getId());


        }else{

            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);


        }

    }
}
