<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryShopRepository;
use App\Repository\ProduitsRepository;


class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CategoryShopRepository $categoryRepository, ProduitsRepository $produitsRepository): Response
    {
        $categorie = $categoryRepository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'produits' => $produitsRepository->findAll(),  
            'categorie' => $categorie,
        ]);
    }
    
}

