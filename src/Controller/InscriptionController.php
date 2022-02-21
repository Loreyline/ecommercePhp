<?php

namespace App\Controller;

use App\Classe\Mailing;
use App\Entity\User;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class InscriptionController extends AbstractController
{
    // entityManager : Doctrine : éxécuter les requêtes
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    #[Route('/inscription', name: 'inscription')]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(InscriptionType::class, $user);

        // écoute de la requête du submit
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // récupérer les données du formulaire
            $user = $form->getData();
            //vérifier si le mail existe
            $userexiste = $this->em->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]);
            if (!$userexiste) {
                // récupérer le mot de passe en clair
                $PlaintextPassword = $user->getPassword();
                // crypter le mot de passe
                $hashedPassword = $passwordHasher->hashPassword(
                    $user,
                    $PlaintextPassword
                );
                // mettre à jour le mot de passe crypté du user
                $user->setPassword($hashedPassword);
                // préparer les données à envoyer vers la BDD
                $this->em->persist($user);
                // sauvegarder dans la BDD
                $this->em->flush();
                //envoie d'email de confirmation
                $email = new Mailing();
                $email->envois(
                    $user->getEmail(),
                    $user->getNom(),
                    "Inscription réussie",
                    "Bravo vous etes inscrit et vous pouvez maintenant vous connecter"
                );
                // $notif = "félicitation vous êtes bien inscrit, vérifiez vos mails";
            } else {
                // $notif = "échec d'inscription l'email existe déjà";
            }
        }
        return $this->render('inscription/inscription.html.twig', [
            'inscrire' => $form->createView(),
            // 'notif' => $notif
        ]);
    }

    // public function delete(UserPasswordHasherInterface $passwordHasher, UserInterface $user)
    // {
    //     // ... e.g. get the password from a "confirm deletion" dialog
    //     $plaintextPassword = $user->getPassword();

    //     if (!$passwordHasher->isPasswordValid($user, $plaintextPassword)) {
    //         throw new AccessDeniedHttpException();
    //     }
    // }
}
