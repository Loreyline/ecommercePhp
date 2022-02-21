<?php

namespace App\Controller;

use App\Classe\Recherche;
use App\Entity\Article;
use App\Form\RechercheType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogueController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/catalogue', name: 'catalogue')]
    public function index(Request $request): Response
    {
        // Fonctionnement SessionInterface
        // est dépréciée et remplacée par RequestStack 
        // équivalent LocalStorage avec les méthodes de SessionInterface
        /*
            Tester RequestStack
            dans une session : les données sont stockées sous forme de couple: clé => valeur
            panier => []
            user => []
        
            $rs->getSession()->set('panier', [
                [
                    'name' => 'chaton blanc',
                    'prix' => 10,
                    'quantite' => 1
                ]
            ]);
            dd($rs->getSession()->get('panier'));
            
            // vider la session
                $rs->getSession()->remove('panier');
        */
        $recherche = new Recherche();
        $products = $this->em->getRepository(Article::class)->findAll();

        $form = $this->createForm(RechercheType::class, $recherche);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recherche = $form->getData();
            $products = $this->em->getRepository(Article::class)->findBySearch($recherche);
        }

        return $this->render('catalogue/catalogue.html.twig', [
            'articles' => $products,
            'form' => $form->createView()
        ]);
        //autre possibilité
        // $articles = $doctrine->getRepository(Article::class)->findAll();

        // return $this->render('catalogue/catalogue.html.twig', [
        //     'articles' => $articles
        // ]);
    }

    #[Route('/article/{id}', name: 'article_show')]
    public function show(int $id): Response
    {

        $article = $this->em->getRepository(Article::class)->find($id);

        return $this->render('catalogue/article.html.twig', [
            'article' => $article
        ]);
    }
}
