<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Form\ContactType;
use App\Repository\CategoryShopRepository;


class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer, CategoryShopRepository $categoryRepository): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

          if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $content = $data['content'];

            // Adresse e-mail de l'expéditeur
            $fromEmail = 'c3f846@inbox.mailtrap.io'; 

            // Adresse e-mail du destinataire (Mailtrap)
            $toEmail = 'to@example.com'; 

            $email = (new Email())
                ->from($fromEmail)
                ->to($toEmail)
                ->subject('Demande de contact')
                ->text($content);

            $mailer->send($email);
            // message alert si le message a bien été envoyé 
            $this->addFlash('success', 'Votre message a bien été envoyé.   Nous vous répondrons dans les plus bref délais !');

            // Reste sur la page contact apres l'envoi du messsage
            return $this->redirectToRoute('app_contact');
        }

        $categorie = $categoryRepository->findAll();

        // Affichage du formulaire s'il n'est pas encore soumis ou s'il n'est pas valide
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            'categorie' => $categorie,
            ]);
    }
    
}
