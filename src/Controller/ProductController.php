<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Tag;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @Route("/product/add", name="add_product")
     * @Route("product/edit/{id<\d+>}", name="edit_product")
     */

    public function addProduct(EntityManagerInterface $objectManager, Request $request, SluggerInterface $slugger,
                               Product $product = null)  {
        if($product === null){
            $product = new Product();
        }
        $form = $this->createForm(ProductType::class, $product/*,[
            'validation_group'=>['Default', $product->getId()?'add' : 'edit']
        ]*/); // App\Form\ProductType
        $form->add('submit',SubmitType::class, [
            'label' =>($product->getId()?"Editer" : "Ajouter")." votre produit"
        ]);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            $user = $this->getUser();
            $product->setUser($user);
            $product->setRef(substr(str_shuffle(md5(random_int(0, 1000000))), 0, 25));
            foreach ($product->getTags() as $tag){
                if(empty($tag->getId())) {
                    $tag->setSlug($slugger->slug($tag->getName())->lower()->toString());
                    $objectManager->persist($tag);
                }
            }
            $objectManager->persist($product);
            $objectManager->flush();
            return $this->redirectToRoute('profile');
        }
        return $this->render('product/product-form.html.twig', [
            'form' => $form->createView()]);
    }

    /**
     * @route("/product/tag/{slug}", name="products_by_tag")
     */
    public function productsByTag(Tag $tag/*, ProductRepository $productRepository*/) {
        // SELECT * FROM products WHERE tag_id = :tag-id
//        $products = $productRepository->findByTag($tag);
        return $this->render('product/products_by_tag.html.twig', [
            'tag' => $tag,
            //            'products'=> $products
        ]);
    }

    /**
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @Route("/product/delete/{id<\d+>", name="delete_product")
     */
    public function deleteProduct(EntityManagerInterface $objectManager, Product $product)
    {
        if($product->getUser() !== $this->getUser()){
            return $this->createAccessDeniedException();
        }
        $objectManager->remove($product);
        $objectManager->flush();
        return $this->redirectToRoute('profile');
    }

    /**
     * @Route("product/category/{slug}", name="products_by_category")
     */
    public function getProductsByCategory(Category $category)
    {
        return $this->render('product/products_by_category.html.twig', [
            'category'=>$category
        ]);

    }

}
