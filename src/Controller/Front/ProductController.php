<?php

namespace App\Controller\Front;

use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Subcategory;
use App\Entity\Marque;
use App\Entity\PanierLigne;
use App\Entity\Commande;
use App\Entity\LigneCommande;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Util\SecureRandom;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

class ProductController extends AbstractController
{
    /**
     *
     * @Route("/product", name="product")
     * @Method("GET")
     */
    public function listeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $em1 = $this->getDoctrine()->getManager();
        $product= $this->getDoctrine()->getRepository(Product::class)->findAll();
        $marque= $this->getDoctrine()->getRepository(Marque::class)->findAll();
        $category= $this->getDoctrine()->getRepository(Category::class)->findAll();
        $categoryy= $this->getDoctrine()->getRepository(Category::class)->findAll();
        $subcategory= $this->getDoctrine()->getRepository(Subcategory::class)->findByCategory($category);
        $panier= $this->getDoctrine()->getRepository(PanierLigne::class)->findAll();
        //$subcategory=$em->getRepository(Subcategory::class)->findByCategory( $em->getRepository(Category::class)->find($categoryy));
        //$subcategory= $this->getDoctrine()->getRepository(Subcategory::class)->findBy(array('category_id' => $categoryy));
        return $this->render('listProduct.html.twig',['product'=> $product,'subcategory'=> $subcategory,'category'=> $category,'marque'=> $marque,'panier'=> $panier]);
        
    }

        /**
     * Finds and displays a product details entity.
     *
     * @Route("/product/{id}", name="product_details")
     * @Method("GET")
     */
    public function detailsAction(Product $product)
    {
        $product= $this->getDoctrine()->getRepository(Product::class)->find($product);
        $marque= $this->getDoctrine()->getRepository(Marque::class)->findAll();
        $category= $this->getDoctrine()->getRepository(Category::class)->findAll();
        $subcategory= $this->getDoctrine()->getRepository(Subcategory::class)->findAll();
        $panier= $this->getDoctrine()->getRepository(PanierLigne::class)->findAll();
        return $this->render('productDetails.html.twig',['product'=> $product,'category'=> $category,'subcategory'=> $subcategory,'marque'=> $marque,'panier'=> $panier]);
    }


    /**
     *
     * @Route("/subcat/{id}", name="product_subcat")
     * @Method("GET")
     */
    public function subcategoryAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $em1 = $this->getDoctrine()->getManager();
        $em2=$this->getDoctrine()->getManager();
        $em3=$this->getDoctrine()->getManager();
        $marque=$em1->getRepository(Marque::class)->findAll();
        $category=$em3->getRepository(Category::class)->findAll();
        $subcategory=$em2->getRepository(Subcategory::class)->findAll();
        $panier= $this->getDoctrine()->getRepository(PanierLigne::class)->findAll();
        $product = $em->getRepository(Product::class)->findBySubcategory( $em->getRepository(Subcategory::class)->find($id));

        return $this->render('listProduct.html.twig', array(
            'subcategory' => $subcategory,
            'category' => $category,
            'product'=>$product,
            'marque'=> $marque,
            'panier'=> $panier,
        ));
    }

/**
     *
     * @Route("/cat/{id}", name="product_cat")
     * @Method("GET")
     */
    public function categoryAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $em1 = $this->getDoctrine()->getManager();
        $em2=$this->getDoctrine()->getManager();
        $em3=$this->getDoctrine()->getManager();
        $marque=$em1->getRepository(Marque::class)->findAll();
        $subcategory=$em3->getRepository(Subcategory::class)->findAll();
        $panier= $this->getDoctrine()->getRepository(PanierLigne::class)->findAll();
        $category=$em2->getRepository(Category::class)->findAll();
        $product = $em->getRepository(Product::class)->findByCategory( $em->getRepository(Category::class)->find($id));

        return $this->render('listProduct.html.twig', array(
            'category' => $category,
            'subcategory' => $subcategory,
            'product'=>$product,
            'marque'=> $marque,
            'panier'=> $panier,
        ));
    }
/**
     *
     * @Route("/filtre/{id}", name="filtre_product")
     * @Method("GET")
     */
    public function filtreproduitAction(Request $request,$id){

        $em = $this->getDoctrine()->getManager();
        $em1 = $this->getDoctrine()->getManager();
        $em2=$this->getDoctrine()->getManager();
        $em3=$this->getDoctrine()->getManager();
        $subcategory=$em1->getRepository(Subcategory::class)->findAll();
        $category=$em2->getRepository(Category::class)->findAll();
        $marque=$em3->getRepository(Marque::class)->findAll();
        $panier= $this->getDoctrine()->getRepository(PanierLigne::class)->findAll();
        $product = $em->getRepository(Product::class)->findByMarque($em->getRepository(Marque::class)->find($id));

        return $this->render('listProduct.html.twig',array(
            'category' => $category,
            'subcategory' => $subcategory,
            'marque'=> $marque,
           'product' => $product,
           'panier'=> $panier,));

    }

     /**
     *
     * @Route("/subcats/{id}", name="product_topsubcat")
     * @Method("GET")
     */
    public function topsubcategoryAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $em2=$this->getDoctrine()->getManager();
        $em3=$this->getDoctrine()->getManager();
        $category=$em3->getRepository(Category::class)->findAll();
        $subcategory=$em2->getRepository(Subcategory::class)->findAll();
        $panier= $this->getDoctrine()->getRepository(PanierLigne::class)->findAll();
        $product = $em->getRepository(Product::class)->findBySubcategory( $em->getRepository(Subcategory::class)->find($id))->setMaxResults(4);

        return $this->render('listProduct.html.twig', array(
            'subcategory' => $subcategory,
            'category' => $category,
            'product'=>$product,
            'marque'=> $marque,
            'panier'=> $panier,
        ));
    }

 

/**
     *
     * @Route("/{id}/cart", name="produit_cart")
     * @Method("GET")
     */
    public function addToCartAction(Request $request, Product $produit)
    {
        $cart = new LigneCommande();
        $category= $this->getDoctrine()->getRepository(Category::class)->findAll();
        $product= $this->getDoctrine()->getRepository(Product::class)->findAll();
        $marque= $this->getDoctrine()->getRepository(Marque::class)->findAll();
        $subcategory= $this->getDoctrine()->getRepository(Subcategory::class)->findAll();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $user->getId();
        $routeParams = $request->attributes->get('_route_params');
        $produit->getId();
        $name = $produit->getNom();
        $cart->setIdUser($user);
        $cart->setIdProduit($produit);
        $em = $this->getDoctrine()->getManager();
        $x = $em->getRepository(LigneCommande::class)->findOneBy(array('idProduit' => $produit, 'idUser' => $user));
        if ($x == null) {
            $cart->setQuantite(1);
            $em1 = $this->getDoctrine()->getManager();
            $em1->persist($cart);
            $em1->flush();
            $this->addFlash('success', 'Produit ajouté à votre panier !');


        } else {

            $em1 = $this->getDoctrine()->getManager();
            $cart = $em1->getRepository(LigneCommande::class)->findOneBy(array('idProduit' => $produit, 'idUser' => $user));
            $cart->setQuantite($cart->getQuantite() + 1);
            $em1->flush();
            $this->addFlash('success', 'La quantité a été mise à jour !');
        }

        $panier = new PanierLigne();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $user->getId();
        $routeParams = $request->attributes->get('_route_params');
        $produit->getId();
        $name = $produit->getNom();
        $panier->setIdUser($user);
        $panier->setIdProduct($produit);
        $em3 = $this->getDoctrine()->getManager();
        $x = $em3->getRepository(PanierLigne::class)->findOneBy(array('idProduct' => $produit, 'idUser' => $user, 'idCommande' => null));
        if ($x == null) {
            $panier->setQuantite(1);
            $em4 = $this->getDoctrine()->getManager();
            $em4->persist($panier);
            $em4->flush();


        } else {

            $em4 = $this->getDoctrine()->getManager();
            $panier = $em4->getRepository(PanierLigne::class)->findOneBy(array('idProduct' => $produit, 'idUser' => $user, 'idCommande' => null));
            $panier->setQuantite($cart->getQuantite() + 1);
            $em4->flush();
        }

        $em2 = $this->getDoctrine()->getManager();

        $carts = $em2->getRepository(LigneCommande::class)->findAll();
        return $this->render('listProduct.html.twig', array(
            'subcategory' => $subcategory,
            'category' => $category,
            'product'=>$product,
            'marque'=> $marque,
            'panier'=> $panier,
            'idProduct' => $produit,
            'idUser' => $user,
            'idCommande' => null,
        ));

    }


    /**
     *
     * @Route("/cart", name="produit_viewC")
     * @Method("GET")
     */
    public function cartAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $user->getId();
        $marque= $this->getDoctrine()->getRepository(Marque::class)->findAll();
        $panier= $this->getDoctrine()->getRepository(PanierLigne::class)->findAll();
        $subcategory= $this->getDoctrine()->getRepository(Subcategory::class)->findAll();
        $em2 = $this->getDoctrine()->getManager();
        $carts = $em2->getRepository(LigneCommande::class)->findBy(array('idUser' => $user));;
        $product = $em2->getRepository(Product::class)->findAll();
        $category = $em2->getRepository(Category::class)->findAll();
        return $this->render('cart.html.twig', array(
            'carts' => $carts,
            'subcategory' => $subcategory,
            'category' => $category,
            'product'=>$product,
            'marque'=> $marque,
            'panier'=> $panier,

        ));
    }

/**
     *
     * @Route("/{id}/deleteCart", name="cart_delete")
     * @Method("GET")
     */
    public function deleteCartAction(Request $request, LigneCommande $ligneCommande)
    {

        $id_cart = $request->get('id');

        $em = $this->getDoctrine()->getManager();
        $ligneCommande = $em->getRepository(LigneCommande::class)->find($id_cart);
        $em->remove($ligneCommande);
        $em->flush();
        $this->addFlash('success', 'Produit retiré de votre panier !');

        $id_cart = $request->get('id');

        $em = $this->getDoctrine()->getManager();
        $ligneCommande = $em->getRepository(PanierLigne::class)->find($id_cart);
        $em->remove($ligneCommande);
        $em->flush();
        return $this->redirectToRoute('produit_viewC');

    }

    /**
     *
     * @Route("/commande", name="produit_commande")
     * @Method("GET")
     */
    public function confirmCartAction(Request $request)
    {


        $total = $request->query->get('tot');
        $commande = new Commande();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $user->getId();
        $commande->setIdUser($user);
        $commande->setEtat("En cours de traitement");
        $commande->setTotal($total);
        $em1 = $this->getDoctrine()->getManager();
        $em1->persist($commande);
        $em1->flush();
        $panier = new PanierLigne();
        $em4 = $this->getDoctrine()->getManager();
        $panier = $em4->getRepository(PanierLigne::class)->findBy(array('idCommande' => NULL, 'idUser' => $user));
        foreach ($panier as $l) {
            $l->setIdCommande($commande);
        }
        $em4->flush();

        $ligneCommande = new LigneCommande();
        $em5 = $this->getDoctrine()->getManager();
        $ligneCommande = $em5->getRepository(LigneCommande::class)->findBy(array('idUser' => $user));
        foreach ($ligneCommande as $lig) {
            $em5->remove($lig);
        }
        $em5->flush();


        return $this->redirectToRoute('produit_viewCO');
    }

    /**
     *
     * @Route("/commandeA", name="produit_viewCO")
     * @Method("GET")
     */
    public function commandeAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $user->getId();
        $marque= $this->getDoctrine()->getRepository(Marque::class)->findAll();
        $panier= $this->getDoctrine()->getRepository(PanierLigne::class)->findAll();
        $subcategory= $this->getDoctrine()->getRepository(Subcategory::class)->findAll();
        $product = $this->getDoctrine()->getRepository(Product::class)->findAll();
        $em2 = $this->getDoctrine()->getManager();
        $carts = $em2->getRepository(Commande::class)->findOneBy(array('etat' => "En cours de traitement", 'idUser' => $user));
        $category = $em2->getRepository(Category::class)->findAll();
        return $this->render('commande.html.twig', array(

            'carts' => $carts,
            'subcategory' => $subcategory,
            'category' => $category,
            'product'=>$product,
            'marque'=> $marque,
            'panier'=> $panier,


        ));
    }

    /**
     *
     * @Route("/{id}/commandeValidee", name="produit_commandeV")
     * @Method("GET")
     */
    public function validerCommandeAction(Request $request, Commande $commande)
    {
        $id_commande = $request->get('id');

        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository(Commande::class)->find($id_commande);
        $commande->setEtat("Validée");
        $em->flush();
        return $this->redirectToRoute('commande');

    }

     /**
     *
     * @Route("/{id}/commandeRefusee", name="produit_commandeR")
     * @Method("GET")
     */

    public function refuserCommandeAction(Request $request, Commande $commande)
    {
        $id_commande = $request->get('id');

        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository(Commande::class)->find($id_commande);
        $commande->setEtat("Refusée");
        $em->flush();
        return $this->redirectToRoute('commande');
    }

     /**
     *
     * @Route("/{id}/commandeDetails", name="produit_commandeDetails")
     * @Method("GET")
     */

    public function afficherDetailsAction(Request $request,Commande $commande)
    {
        $id_commande = $request->get('id');

        $em4 = $this->getDoctrine()->getManager();
        $paniers = $em4->getRepository(PanierLigne::class)->findBy(array('idCommande' => $id_commande));
        $em2 = $this->getDoctrine()->getManager();
        $produit = $em2->getRepository(Product::class)->findAll();
        return $this->render('detailsCommande.html.twig', array(
            'produit' => $produit,
            'paniers' => $paniers

        ));

    }
}
