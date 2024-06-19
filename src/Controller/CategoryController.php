<?php

namespace App\Controller;

use App\Entity\CategoryShop;
use App\Repository\CategoryShopRepository;
use App\Repository\ProduitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category/{id}', name: 'app_category')] /* Je récupére ma category grace à son id */ 
    public function index($id, CategoryShopRepository $categoryRepository, ProduitsRepository $produitsRepository): Response
    {
        $category = $categoryRepository->find($id);
        $produits = $produitsRepository->findBy(['Category' => $category]);
        $categorie = $categoryRepository->findAll();
    
         /* j'ai mis une condition pour savoir si ma categorie existe ou pas si non elle execute le createNotFoundException  */ 
        if (!$category) {
            throw $this->createNotFoundException('La catégorie n\'existe pas');
        }
         /* la sa va recuperer tout les produits par categorie */ 
        $produits = $produitsRepository->findBy(['Category' => $category]); 

        return $this->render('category/index.html.twig', [
            'category' => $category,
            'produits' => $produits,
            'categorie' => $categorie
        ]);
    }

}
