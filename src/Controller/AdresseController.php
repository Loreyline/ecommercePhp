<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Form\AdresseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdresseController extends AbstractController
{
    // entityManager : Doctrine : éxécuter les requêtes
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/profil/adresse/adresse', name: 'ajout_adresse')]
    public function AjoutAdresse(Request $request): Response
    {
        $user = $this->getUser();
        $adresse = new Adresse();
        $form = $this->createForm(AdresseType::class, $adresse);

        // écoute de la requête du submit
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // récupérer les données du formulaire
            $adresse = $form->getData();
            // récupérer le user en cours
            $adresse->setUser($user);
            // préparer les données à envoyer vers la BDD
            $this->em->persist($adresse);
            // sauvegarder dans la BDD
            $this->em->flush();
            return $this->redirectToRoute('afficher_adresse');
        }
        return $this->render('profil/adresse/gererAdresse.html.twig', [
            'adresse' => $form->createView()
        ]);
    }

    #[Route('/profil/adresse/afficherAdresse', name: 'afficher_adresse')]
    public function AfficherAdresse(): Response
    {
        return $this->render('profil/adresse/afficherAdresse.html.twig');
    }

    #[Route('/profil/adresse/supprimerAdresse/{id}', name: 'supprimer_adresse')]
    public function SupprimerAdresse($id, Request $request): Response
    {
        $adresse = $this->em->getRepository(Adresse::class)->find($id);
        $user = $this->getUser();

        if ($adresse && ($user == $adresse->getUser())) {
            $this->em->remove($adresse);
            $this->em->flush();
        }

        return $this->redirectToRoute('afficher_adresse');
    }

    #[Route('/profil/adresse/ModifierAdresse/{id}', name: 'modif_adresse')]
    public function ModifAdresse($id, Request $request): Response
    {
        $user = $this->getUser();
        $adresse = $this->em->getRepository(Adresse::class)->find($id);

        if ($adresse && ($user == $adresse->getUser())) {
            $form = $this->createForm(AdresseType::class, $adresse);
            // écoute de la requête du submit
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // récupérer les données du formulaire
                $adresse = $form->getData();
                // sauvegarder dans la BDD
                $this->em->flush();
                return $this->redirectToRoute('afficher_adresse');
            }
            return $this->render('profil/adresse/gererAdresse.html.twig', [
                'adresse' => $form->createView()
            ]);
        }
    }
}
