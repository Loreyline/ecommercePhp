<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commande;
use Stripe\Checkout\Session;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController
{
    // entityManager : Doctrine : éxécuter les requêtes
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route(
        '/profil/commande/create-session/{reference}',
        name: 'stripe_create_session'
    )]
    public function index($reference): Response
    {
        $ref = str_replace(' ', '', $reference);

        $sessionProducts = [];
        $YOUR_DOMAIN = 'http://127.0.0.1:8000';
        $commande = $this->em
            ->getRepository(Commande::class)
            ->findOneBy(['reference' => $ref]);
        // Remplir le sessionProducts via les lignes de commandes
        foreach ($commande->getLigneCommandes()->getValues() as $product) {

            $prod = $this->em
                ->getRepository(Article::class)
                ->findOneBy(['name' => $product->getArticleNom()]);
            //dd($prod);
            $sessionProducts[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product->getArticlePrix(),
                    'product_data' => [
                        'name' => $product->getArticleNom(),
                        'images' => ["assets/images/produits/" . $prod->getImage()]
                    ]
                ],
                'quantity' => $product->getArticleQuantite()
            ];
        }
        // Ajouter les frais de livraison
        $sessionProducts[] = [
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $commande->getTransPrix() * 100,
                'product_data' => [
                    'name' => $commande->getTransporteur(),
                    'images' => [$YOUR_DOMAIN]
                ]
            ],
            'quantity' => 1
        ];
        // La clé secrête
        Stripe::setApiKey('sk_test_51KT0u7IDqUuSHYx0vhxP3pyG4cCb6JcbRSi4TEx0yNiu0ytvtJjTexvd9HnaVZxFyGZSMMGTVRtZvIfqHevzRj2900ewwkOZAZ');
        // Création de la session checkout
        $checkout_session = Session::create([
            'customer_email' => $this->getUser()->getEmail(),
            'payment_method_types' => ['card'],
            'line_items' => [
                $sessionProducts
            ],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/profil/commande/success/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . '/profil/commande/cancel',
        ]);
        $sessionId = $checkout_session->id;
        $commande->setStripeSessionId($sessionId);
        $this->em->flush();

        $response = new JsonResponse(['id' => $sessionId]);
        return $response;
    }
}
