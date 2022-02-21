<?php

namespace App\Controller;

use App\Classe\Panier;
use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RetourStripeController extends AbstractController
{
    // entityManager : Doctrine : éxécuter les requêtes
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    #[Route('/profil/commande/success/{stripeSessionId}', name: 'commandeSuccess')]
    public function index($stripeSessionId, Panier $panier): Response
    {
        //dump($stripeSessionId);

        $commande = $this->em->getRepository(Commande::class)->findOneBy([
            'stripeSessionId' => $stripeSessionId
        ]);

        if (!$commande) {
            return $this->redirectToRoute('accueil');
        }
        //Modifier isFinalisee
        $commande->setIsFinalisee(1);
        $this->em->flush();

        //vider le panier
        $panier->vider();

        return $this->render('retour_stripe/success.html.twig', [
            'commande' => $commande
        ]);
    }

    #[Route('/profil/commande/cancel', name: 'cancel')]
    public function cancel(Panier $panier): Response
    {
        //vider le panier
        $panier->vider();
        return $this->render('retour_stripe/cancel.html.twig');
    }
}
