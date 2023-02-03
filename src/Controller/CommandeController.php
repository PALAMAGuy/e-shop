<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CommandeProduitRepository;

#[Route('/commande')]
class CommandeController extends AbstractController
{
    #[Route('/', name: 'app_commande_index', methods: ['GET'])]
    public function index(CommandeRepository $commandeRepository): Response
    {
        if(!$this->isGranted('ROLE_USER')){
            return $this->redirectToRoute('app_main');
        }
        $user = $this->getUser();
        return $this->render('commande/index.html.twig', [
            'commandes' => $commandeRepository->findBy(['user'=>$user])
        ]);
    }
    /*
    #[Route('/new', name: 'app_commande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CommandeRepository $commandeRepository): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_main');
        }

        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commandeRepository->save($commande, true);

            return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande/new.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }
    */
    #[Route('/newcmd', name: 'app_commande_newcmd', methods: ['GET', 'POST'])]
    public function newCmd(Request $request, CommandeRepository $commandeRepository): Response
    {
        $user = $this->getUser();

        $commande = new Commande();
        $commande->setStatus("En cours");
        $commande->setPrix(0);
        $commande->setUser($user);  
        $commande->setCreatedDate(new \DateTime());
        $commandeRepository->save($commande, true);
        return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);

    }

    #[Route('/{id}', name: 'app_commande_show', methods: ['GET'])]
    public function show(Commande $commande,CommandeProduitRepository $commandeProduitRepository): Response
    {
        $user = $this->getUser();
        
        if($user != $commande->getUser()){

            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);

        }
        else{

            $produit = $commandeProduitRepository->findBy(['commande'=>$commande]);
            $total = 0;

            foreach($produit as $produit){

                $total = $total + $produit->getPrix();

            }
            
            return $this->render('commande/show.html.twig', [
                'commande' => $commande,
                'commande_produits' => $commandeProduitRepository->findBy(['commande'=>$commande]),
                'total' => $total
            ]);
        }
  
    }
    /*
    #[Route('/{id}/edit', name: 'app_commande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commande $commande, CommandeRepository $commandeRepository): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_main');
        }

        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commandeRepository->save($commande, true);

            return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }
    */
    /*
    #[Route('/{id}', name: 'app_commande_delete', methods: ['POST'])]
    public function delete(Request $request, Commande $commande, CommandeRepository $commandeRepository): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_main');
        }

        if ($this->isCsrfTokenValid('delete'.$commande->getId(), $request->request->get('_token'))) {
            $commandeRepository->remove($commande, true);
        }

        return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
    }
    */
}
