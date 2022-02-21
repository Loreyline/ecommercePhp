<?php

namespace App\Controller;

use App\Classe\Panier;
use App\Entity\Commande;
use App\Entity\LigneCommande;
use App\Form\ChoixTransporteurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecapController extends AbstractController
{
    // entityManager : Doctrine : éxécuter les requêtes
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    #[Route('/profil/recap/{adrL}/{adrF}', name: 'recap')]
    public function index($adrL, $adrF, Request $request, Panier $panier): Response
    {
        $transport = null;
        $reference = null;
        $formTransport = $this->createForm(ChoixTransporteurType::class, null, [
            'user' => $this->getUser()
        ]);

        $formTransport->handleRequest($request);
        if ($formTransport->isSubmitted() && $formTransport->isValid()) {

            $transport = $formTransport->get('transporteurs')->getData();

            // préparation de l'objet commande
            $date = new \DateTimeImmutable();
            $reference = $date->format('dmY') . '-' . uniqid();
            $currentUser = $this->getUser();
            $transporteur = $transport->getNom();
            $transPrix = $transport->getPrix();
            $isFinalisee = false;

            // remplissage de l'objet commande
            $cmd = new Commande();
            $cmd->setUser($currentUser);
            $cmd->setCreatedAt($date);
            $cmd->setReference($reference);
            $cmd->setAdresseLivraison($adrL);
            $cmd->setAdresseFacturation($adrF);
            $cmd->setTransporteur($transporteur);
            $cmd->setTransPrix($transPrix);
            $cmd->setIsFinalisee($isFinalisee);

            $this->em->persist($cmd);

            // préparation de l'objet LigneCommande
            foreach ($panier->afficherTout() as $article) {
                $cmdLigne = new LigneCommande();
                $cmdLigne->setCommande($cmd);
                $cmdLigne->setArticleNom($article['article']->getName());
                $cmdLigne->setArticleQuantite($article['quantite']);
                $cmdLigne->setArticlePrix($article['article']->getPrix());
                $cmdLigne->setTotal(($article['article']->getPrix()) * ($article['quantite']));
                $this->em->persist($cmdLigne);
            }

            $this->em->flush();
        }

        return $this->render('profil/recap.html.twig', [
            'transport' => $transport,
            'panier' => $panier->afficherTout(),
            'adrL' => $adrL,
            'adrF' => $adrF,
            'reference' => $reference
        ]);
    }

    #[Route('/profil/commandes', name: 'commandes')]
    public function AfficherAdresse(): Response
    {
        return $this->render('profil/commandes.html.twig');
    }

    #[Route('/profil/commande/details/{reference}', name: 'commande')]
    public function show($reference): Response
    {

        $commande = $this->em->getRepository(Commande::class)->findOneBy(['reference' => $reference])->getLigneCommandes()->getValues();
        $cmd = $this->em->getRepository(Commande::class)->findOneBy(['reference' => $reference]);

        return $this->render('profil/commande.html.twig', [
            'cmd' => $cmd,
            'commande' => $commande,
            'reference' => $reference
        ]);
    }
}
