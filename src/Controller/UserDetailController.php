<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserDetailController extends AbstractController
{
    /**
     * @Route("/user/detail/{id<\d+>}", name="user_detail")
     * @Route("/profile}", name="profile")
     */
    public function detail(User $user = null)
    {
        // si on a pas de controleur, celà siginfie qu'on est passé par le profil
        if($user === null) {
            $user = $this->getUser();
        }
        // si malgré tout on n'a pas réussi à récupérer un utilisateur
        // on redirige vers la page d'accueil
        if($user === null) {
            // header('Location:home'); exit;
            return $this->redirectToRoute('home');
        }
        return $this->render('user_detail/index.html.twig', [
            'user_detail' => $user,
        ]);
    }
}
