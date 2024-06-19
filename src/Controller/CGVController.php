<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryShopRepository;


class CGVController extends AbstractController
{
    #[Route('/c/g/v', name: 'app_c_g_v')]
    public function index(CategoryShopRepository $categoryRepository): Response
    {
        $categorie = $categoryRepository->findAll();

        return $this->render('cgv/index.html.twig', [
            'controller_name' => 'CGVController',
            'categorie' => $categorie,
        ]);
    }
    
}
