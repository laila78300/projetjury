<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Repository\CategoryShopRepository;

class SecurityController extends AbstractController
{

    #[Route(path: '/connexion', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, CategoryShopRepository $categoryRepository): Response
    {
        $categorie = $categoryRepository->findAll();

        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig',[
           'last_username' => $lastUsername,
           'error' => $error,
           'categorie' => $categorie,
       ]);
   }

    #[Route(path: '/deconnexion', name: 'app_logout')]
    public function logout(Request $request): void
    {
        // route pour la deconnexion
    }

    // redirige vers la page d'accueil aprés la deconnexion
    public function onLogoutSuccess(Request $request): RedirectResponse
    {
        $targetUrl = $this->generateUrl('app_home'); 
        return new RedirectResponse($targetUrl);
    }
}
