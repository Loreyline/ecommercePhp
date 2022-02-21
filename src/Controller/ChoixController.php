<?php

namespace App\Controller;


use App\Form\ChoixAdresseType;
use App\Form\ChoixTransporteurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChoixController extends AbstractController
{
    // entityManager : Doctrine : éxécuter les requêtes
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    #[Route('/profil/choix/adresse', name: 'choix_adresse')]
    public function index(): Response
    {
        $form = $this->createForm(ChoixAdresseType::class, null, [
            'user' => $this->getUser()
        ]);

        return $this->render('profil/choixAdresse.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/profil/choix/transporteur', name: 'choix_transporteur')]
    public function transport(Request $request): Response
    {
        $adrL = null;
        $adrF = null;

        $formAdresse = $this->createForm(ChoixAdresseType::class, null, [
            'user' => $this->getUser()
        ]);
        $formAdresse->handleRequest($request);
        if ($formAdresse->isSubmitted() && $formAdresse->isValid()) {
            $adrL = $formAdresse->get('adressesLivraison')->getData();
            $adrF = $formAdresse->get('adressesFacturation')->getData();
        }


        $form = $this->createForm(ChoixTransporteurType::class, null, [
            'user' => $this->getUser()
        ]);

        return $this->render('profil/choixTransporteur.html.twig', [
            'form' => $form->createView(),
            'adrL' => $adrL,
            'adrF' => $adrF
        ]);
    }
}
