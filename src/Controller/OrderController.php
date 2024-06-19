<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Entity\Transporteur;
use App\Form\OrderType;
use App\Repository\ProduitsRepository;
use App\Repository\TransporteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface; 
use App\Repository\CategoryShopRepository;

class OrderController extends AbstractController
{
    #[Route('/order', name: 'app_order')]
    public function order( Request $request, SessionInterface $session, ProduitsRepository $produitsRepository, TransporteurRepository $transporteurRepository, EntityManagerInterface $entityManager, CategoryShopRepository $categoryRepository): Response 
    {
         // J'ai mis une condition si l'utilisateur veut voir sa commande avec le recapitulatif il doit etre inscrit ou s'inscrire //
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $panier = $session->get('panier', []);
        $data = [];

        foreach ($panier as $id => $quantity) {
            $produit = $produitsRepository->find($id);
            $data[] = [
                'produit' => $produit,
                'quantity' => $quantity
            ];
        }

        $transporteurPrice = 5;  // j'ai mis 5€ comme prix fixe pour le transporeur 

        $total = 0;  // on obtiendra le montant total de la commande 
        foreach ($data as $item) {
            $total += $item['produit']->getPrice() * $item['quantity'];
        }

        $total += $transporteurPrice; // Calcul du montant total + le prix du transport et la sa va etre 5€ 

        $session->set('total_amount', $total); 

        $form = $this->createForm(OrderType::class, null, [   // le formulaire se creer via le modele que j'ai fais dans orderType
            'user' => $this->getUser()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();  // on enregistre le formulaire
            
            $entityManager->persist($formData);
            $entityManager->flush();

        }

        $categorie = $categoryRepository->findAll();

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'data' => $data, 
            'transporteurPrice' => $transporteurPrice ,
            'categorie' => $categorie
        ]);
    }
}
