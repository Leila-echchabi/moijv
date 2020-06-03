<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/{id<\d+>}", name="product")
     */
//    public function detail(Request $request, ProductRepository $productRepo)
//    {
//        // /product/5
//        //$id = $_GET['id'];
//        $id = $request->get('id');
//        //SELECT * FROM product WHERE id= :id
//        $product = $productRepo->find($id);
//        // SELECT* FROM user WHERE user.id = :id_user
//        $user = $product->getUser();
//        return $this->render('product/detail.html.twig', [
//            'product' => $product,
//        ]);
//    }

     public function detail(Product $product){
        return $this->render('product/detail.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/product/add", name="add_product")
     */

    public function addProduct()  {
        $form = $this->createForm(ProductType::class);
        $form->add('submit',SubmitType::class);
        return $this->render('product/product-form.html.twig', [ 'form' => $form->createView()]);
    }


}
