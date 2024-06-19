<?php

namespace App\Controller;

use App\Entity\Produits;

use App\Form\ProduitsType;
use App\Repository\ProduitsRepository;
use App\Repository\CategoryShopRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class ProduitsController extends AbstractController
{
    #[Route('/produits', name: 'app_produits_index', methods: ['GET'])]
    public function index(ProduitsRepository $produitsRepository, CategoryShopRepository $categoryRepository): Response
    {
        $categorie = $categoryRepository->findAll();

        return $this->render('produits/index.html.twig', [
            'produits' => $produitsRepository->findAll(),
            'categorie' => $categorie,
        ]);
    }

    #[Route('/produits/new', name: 'app_produits_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produits();
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($produit);
            $entityManager->flush();

        return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produits/new.html.twig', [
            'produits' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/produits/{id}', name: 'app_produits_show', methods: ['GET'])]
    public function show(Produits $produit, CategoryShopRepository $categoryRepository): Response
    {
        $categorie = $categoryRepository->findAll();

        return $this->render('produits/show.html.twig', [
            'produit' => $produit,
            'categorie' => $categorie,
        ]);
    }

    #[Route('/produits/{id}/edit', name: 'app_produits_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produits $produit, EntityManagerInterface $entityManager, CategoryShopRepository $categoryRepository): Response
    {
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $entityManager->flush();

        return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
        }
        
        $categorie = $categoryRepository->findAll();

        return $this->render('produits/edit.html.twig', [
            'produits' => $produit,
            'form' => $form,
            'categorie' => $categorie,
        ]);
    }

    #[Route('/produits/{id}/delete', name: 'app_produits_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, Produits $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {           
        }
        $entityManager->remove($produit);
        $entityManager->flush();

        return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
    }
   
}
