<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("", name="home")
     */
    public function index(ProductRepository $productRepository)
    {
        //$productRepository = new ProductRepository();
        // On l'a injecté en paramètre dans la fonction index afin queSymfony se charge de l'instancier

        $products = $productRepository->findBy([], [], 6); // correspond $pdo->query("SELECT * FROM product")
        //->fetchAll();
        return $this->render('home/index.html.twig', [
            'productList' => $products,
        ]);
    }
}
