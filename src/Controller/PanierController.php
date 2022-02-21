<?php

namespace App\Controller;

use App\Classe\Panier;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PanierController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    #[Route('/panier', name: 'panier')]
    public function index(Panier $panier): Response
    {
        return $this->render('panier/panier.html.twig', [
            'panier' => $panier->afficherTout()
        ]);
    }

    #[Route('/panier/ajouter/{id}', name: 'ajouterPanier')]
    public function ajouterPanier($id, Panier $panier): Response
    {
        $panier->ajouter($id);

        return $this->redirectToRoute('panier');
    }

    #[Route('/panier/diminuer/{id}', name: 'diminuerArticle')]
    public function diminuerArticle($id, Panier $panier): Response
    {
        $panier->diminuer($id);

        return $this->redirectToRoute('panier');
    }

    #[Route('/panier/supprimer/{id}', name: 'supprimerArticle')]
    public function supprimer($id, Panier $panier): Response
    {
        $panier->supprimer($id);

        return $this->redirectToRoute('panier');
    }


    #[Route('/panier/vider', name: 'viderPanier')]
    public function viderPanier(Panier $panier): Response
    {
        $panier->vider();

        return $this->redirectToRoute('panier');
    }
}
