<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryShopRepository;


class AProposDeNousController extends AbstractController
{
    #[Route('/aproposdenous', name: 'app_a_propos_de_nous')]
    public function index(CategoryShopRepository $categoryRepository): Response
    {
        $categorie = $categoryRepository->findAll();
        
        return $this->render('a_propos_de_nous/index.html.twig', [
            'controller_name' => 'AProposDeNousController',
            'categorie' => $categorie,
        ]);
    }
}
