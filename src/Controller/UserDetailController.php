<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserDetailController extends AbstractController
{
    /**
     * @Route("/user/detail/{id<\d+>}", name="user_detail")
     */
    public function detail(User $user)
    {
        return $this->render('user_detail/index.html.twig', [
            'user_detail' => $user,
        ]);
    }
}
