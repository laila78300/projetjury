<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryShopRepository;


class PolitiqueDeConfidentialitésController extends AbstractController
{
    #[Route('/politique/de/confidentialit/s', name: 'app_politique_de_confidentialit_s')]
    public function index(CategoryShopRepository $categoryRepository): Response
    {
        $categorie = $categoryRepository->findAll();
        
        return $this->render('politique_de_confidentialités/index.html.twig', [
            'controller_name' => 'PolitiqueDeConfidentialitésController',
            'categorie' => $categorie,
        ]);
    }
    
}
