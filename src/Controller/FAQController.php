<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryShopRepository;


class FAQController extends AbstractController
{
    #[Route('/faq', name: 'app_f_a_q')]
    public function index(CategoryShopRepository $categoryRepository): Response
    {
        $categorie = $categoryRepository->findAll();

        return $this->render('faq/index.html.twig', [
            'controller_name' => 'FAQController',
            'categorie' => $categorie,

        ]);
    }
    
}
