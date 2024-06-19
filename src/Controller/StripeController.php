<?php

namespace App\Controller;

use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface; // Import de la classe UrlGeneratorInterface
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface; 
use App\Repository\CategoryShopRepository;

class StripeController extends AbstractController
{
    #[Route('/stripe/checkout/session', name: 'app_stripe_checkout_session')]
    public function checkoutSession(SessionInterface $session): Response
    {
        // Récupére le montant total de la commande depuis la session Symfony
        $totalAmount = $session->get('total_amount', 0);

        // Ma clé secrète Stripe
        \Stripe\Stripe::setApiKey('sk_test_51Or3mURpXCPPDPROrYvTJ4I42fwBbT7QMPkI6VeGIld7PFwucCdryrtj7GiFRMAIHksdYXu2wG96lYHOk0pSMlp600tJblzaUr');

        // Créez une Session de paiement Stripe
        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'eur', 
                        'product_data' => [
                            'name' => 'Total de la commande',
                        ],
                        'unit_amount' => $totalAmount * 100, 
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('app_payment_success', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('app_payment_cancel', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        // Redirige l'utilisateur vers la page de paiement Stripe checkout_session 
        return $this->redirect($checkout_session->url, Response::HTTP_FOUND);
    }

    #[Route('/payment/success', name: 'app_payment_success')]
    public function paymentSuccess(SessionInterface $session, EntityManagerInterface $entityManager, CategoryShopRepository $categoryRepository): Response
    {
        // Récupérer les infonécessaires depuis la session
        $totalAmount = $session->get('total_amount', 0);
        $user = $this->getUser(); 
        $transporterName = $session->get('transporter_name', ''); 
        $transporterPrice = $session->get('transporter_price', 0);
        $delivery = $session->get('delivery', '');
        $method = 'stripe'; 
        $reference = uniqid();  // C'est pour avoir un numero de reference unique
        $stripeSessionId = $session->get('stripe_session_id'); 
    
        // une nouvelle commande Order avec tout ce qui suit
        $order = new Order();
        $order->setCreatedAt(new \DateTime());
        $order->setUser($user);
        $order->setTransporterName($transporterName);
        $order->setTransporterPrice($transporterPrice);
        $order->setDelivery($delivery);
        $order->setIsPaid(true); // Marquer comme payé
        $order->setMethod($method);
        $order->setReference($reference);
        $order->setStripeSessionId($stripeSessionId);
    
        $entityManager->persist($order);  // on persist pour persister dans la base de données
        $entityManager->flush();
    
        $message = "Votre paiement a été effectué avec succès !"; // mon message de réussite succès
    
        $categorie = $categoryRepository->findAll();    // récupere toute les categories findall de la base
    
        return $this->render('stripe/index.html.twig', [    // Return vers la pge index la et j'ai mis un message de succès
            'reference' => $reference,
            'successMessage' => $message,
            'categorie' => $categorie
        ]);
    }
    
    #[Route('/payment/cancel', name: 'app_payment_cancel')]
    public function paymentCancel(): Response
    {
        $message = "Votre paiement a été annulé.";
        
        return new Response($message);
    }
}
