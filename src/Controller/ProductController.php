<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/{id<\d+>}", name="product")
     */
    public function detail(Request $request, ProductRepository $productRepo)
    {
        // /product/5
        //$id = $_GET['id'];
        $id = $request->get('id');
        //SELECT * FROM LEFT JOINT on user ON product.user_id WHERE id= :id
        $product = $productRepo->find($id);
        // SELECT* FROM user WHERE user.id = :id_user
        $user = $product->getUser();
        return $this->render('product/detail.html.twig', [
            'product' => $product,
        ]);
    }
}
