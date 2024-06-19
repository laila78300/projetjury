<?php

namespace App\Controller;

use App\Entity\Produits;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProduitsRepository;
use App\Repository\CategoryShopRepository;


class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]

        public function index(SessionInterface $session, ProduitsRepository $produitsRepository, CategoryShopRepository $categoryRepository)
        {
            $panier = $session->get('panier', []);
    
            // On initialise des variables
            $data = [];
            $total = 0;    
            foreach($panier as $id => $quantity)
            {
                $produit = $produitsRepository->find($id);
    
            // Vérifier si le produit est trouvé
            if($produit !== null) 
            { 
            $data[] = [
                'produit' => $produit,
                'quantity' => $quantity
            ];
            $total += $produit->getPrice() * $quantity;
             } else {

            // Gérer le cas où le produit n'est pas trouvé Par exemple, vous pourriez simplement ignorer ce produit ou le supprimer du panier
            unset($panier[$id]);
            $session->set('panier', $panier);
             }
            }

           $categorie = $categoryRepository->findAll();

           return $this->render('panier/index.html.twig', compact('data', 'total') + [
            'categorie' => $categorie
            ]);       
        }
       
        #[Route('panier/{id}', name: 'app_panier_id')]
        public function addToCart(Produits $produit, SessionInterface $session)
        {
            $id = $produit->getId();
            
            $panier = $session->get('panier', []);
            
            if (empty($panier[$id])) {
                $panier[$id] = 1;
            } else {
                $panier[$id]++;
            }
            
            $session->set('panier', $panier);
            
            return $this->redirectToRoute('app_panier');
        }
        
        #[Route('panier/remove/{id}', name: 'app_panier_remove_id')]
        public function remove(Produits $produit, SessionInterface $session)
        {
            $id = $produit->getId();
        
            $panier = $session->get('panier', []);
        
            if (!empty($panier[$id])) {
                if ($panier[$id] > 1) {
                    $panier[$id]--;
                } else {
                    unset($panier[$id]);
                }
            }
        
            $session->set('panier', $panier);
            
            return $this->redirectToRoute('app_panier');
        }
        
        #[Route('panier/delete/{id}', name: 'app_panier_delete_id')]
        public function delete(Produits $produit, SessionInterface $session)
        {
            $id = $produit->getId();
        
            $panier = $session->get('panier', []);
        
            if (!empty($panier[$id])) {
                unset($panier[$id]);
            }
        
            $session->set('panier', $panier);
            
            return $this->redirectToRoute('app_panier');
        }
        
        #[Route('panier/empty', name: 'app_panier_empty')]
        public function empty(SessionInterface $session)
        {
            $session->remove('panier');
        
            return $this->redirectToRoute('app_panier');
        }    

}   
