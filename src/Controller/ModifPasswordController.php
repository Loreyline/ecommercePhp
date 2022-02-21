<?php

namespace App\Controller;

use App\Form\ModifPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class ModifPasswordController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    #[Route('profil/modifPassword', name: 'modifPassword')]
    public function index(Request $request, UserPasswordHasherInterface $uphi): Response
    {
        $notif = null;
        $user = $this->getUser();
        $form = $this->createForm(ModifPasswordType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $oldPassword = $form->get("oldPassword")->getData();
            if ($uphi->isPasswordValid($user, $oldPassword)) {
                // modification du mot de passe dans la base de données

                // récupérer le nouveau mot de passe
                $newPassword = $form->get("newPassword")->getData();

                //crypter le nouveau mot de passe
                $pwd = $uphi->hashPassword($user, $newPassword);

                // placer le nouveau mot de passe dans l'objet $user
                $user->setPassword($pwd);
                // Actualiser la BDD
                // $this->em->persist($user);
                $this->em->flush();

                // notifier
                $notif = "mot de passe modifié avec succès";
            } else {
                $notif = "mot de passe icorrect";
            }
        }

        return $this->render('/profil/modifPassword.html.twig', [
            'modif' => $form->createView(),
            'notif' => $notif
        ]);
    }
}
