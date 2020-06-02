<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(UserRepository $userRepository)
    {

        $users = $userRepository->findAll();

        return $this->render('user/user_list.html.twig', [
            'user_list' => $users
        ]);
    }
}
