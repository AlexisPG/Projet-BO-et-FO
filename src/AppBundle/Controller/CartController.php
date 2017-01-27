<?php
/**
 * Created by PhpStorm.
 * User: wamobi14
 * Date: 13/01/17
 * Time: 16:25
 */

namespace AppBundle\Controller;

use AdminBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CartController extends Controller
{
    public function createCartActions(Request $request){

        if(!$request->getSession()->has('cart')){
            $request->getSession()->set('cart', [
                'id' => [],
                'qte' => [],
                'title' => [],
                'price' => [],
                'image' => [],
            ]);
            $request->getSession()->set('total_panier', null);

        }else{
            // Lorsqu'on ajoute un produit au panier
            // dump('ajout de produit');die;
        }
    }

    /**
     * @Route("/cart_add/{id}", name="cart_add_product", requirements={"id" = "\d+"})
     */
    public function addCartActions($id, Request $request)
    {
        //initialisation de cart (pendant les tests)
        /*$request->getSession()->set('cart', [
            'id' => [],
            'qte' => [],
            'title' => [],
            'price' => [],
            'img' => [],
        ]);
        $request->getSession()->set('total_panier', null);/*
        //dump('coucou');die;
        //$cart = $this->get('cart');


        //$request->get($Quantity);

        //***********************************/

        if (count($request->getSession()->get('cart')) < 1) {
            $request->getSession()->set('cart', [
                'id' => [],
                'qte' => [],
                'title' => [],
                'price' => [],
                'image' => [],
            ]);
            $cart = $request->getSession()->get('cart');
            $total = 0;
        } else {
            $cart = $request->getSession()->get('cart');
            $total = $request->getSession()->get('total_panier');
            // dump($cart, $total);die;
        }

        //on donne à la variable cart la valeur du tableau de session cart

        //dump($cart);die;
        if ($total > 0 )
        {
            // Dans le cas où le total de $cart est supérieur à 0
        }
        else {
            $total = 0;
        }
        //dump($id);die;
        //dump($cart);die;
        //dump(count($cart));die;
        //$cart = json_decode($cart,true);
        //on vérifie si l'id de l'élément à rajouter dans la panier existe déja
        /*if (count($cart['id']) > 0) {*/

        if (in_array($id, $cart['id'])) {
            //dump("id existe");die;
            //dump($cart);die;
            //on veux la position du produit dans le tableau $cart
            $idValue = array_search($id,$cart['id']);
            //die(dump($cart));
            //on modifie la qte du produit (en position +1 par rapport au produit) en lui rajoutant la qte voulue
            $cart['qte'][$idValue] += $request->get('qte');
            //dump($idValue);die;
            $em = $this->getDoctrine()->getManager();
            //$total = 0;
            $product_infos = [];
            $product_infos = $em->getRepository('AdminBundle:Product')->findProductById($id);
            //dump($total);
            //dump($product_infos['price']);
            //dump($request->get('qte'));
            $total = $total + ($product_infos['price']*$request->get('qte'));
            //dump($total);die;


        }else{
            // si l'id n'éxiste pas on rajoute l'élément et sa qte
            //dump("id non existe");
            //dump($cart);
            //$cart=[['id'],['qte'],['title']];
            //dump($id);die;
            array_push($cart['id'], $id);
            array_push($cart['qte'], $request->get('qte'));

            $em = $this->getDoctrine()->getManager();
            //$total = 0;
            $product_infos = [];
            $product_infos = $em->getRepository('AdminBundle:Product')->findProductById($id);

            //dump($product_infos['titleFR'],$product_infos['price'] );die;

            array_push($cart['title'], $product_infos['titleFR']);
            array_push($cart['price'], $product_infos['price']);
            array_push($cart['image'], $product_infos['image']);
            $total = $total + ($product_infos['price']*$request->get('qte'));

            //dump($cart);die;
        }

        // pour ajouter le produit dans le panier
        //dump($cart);die;
        $request->getSession()->set('cart', $cart);
        $request->getSession()->set('total_panier', $total);

        /**************************************/

        // pour ajouter le produit dans le panier (mais réinitilisation , donc utilisation du push ci-dessus
        /*$request->getSession()->set('cart', [
            'id' => [$id],
            'qte' => [$request->get('qte')],
        ]);*/

        //contenus du panier
        //dump($request->getSession()->get('cart'));
        //dump($request->getSession()->get('cart'));die;
        //die($request->get("qte"));

        //*****redirection vers la page précédente*****
        //source : https://openclassrooms.com/forum/sujet/symfony3-retour-vers-a-page-precedente-apres-updat
        // version sur serveur : dump($request->getSession()->set('referer', $request->headers->get('referer'))); die;
        //version en local :
        //dump($request->headers->get('referer')); die;


//************ code de Nicolas ********

        //$session = $request->getSession();
        //$cart = $session->get('cart');


//********************

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/cart_supp/{id}", name="cart_supp", requirements={"id" = "\d+"})
     */
    public function suppAction($id, Request $request)
    {
        //on donne à la variable cart la valeur du tableau de session cart
        //dump('coucou');die;
        $cart =  $request->getSession()->get('cart');
        $total =  $request->getSession()->get('total_panier');
        $idValue= array_search($id,$cart['id']);

        $em = $this->getDoctrine()->getManager();
        $product_infos = $em->getRepository('AdminBundle:Product')->findProductById($id);
        $total = $total - ($product_infos['price']*$cart['qte'][$idValue]);

        array_splice($cart['qte'],$idValue, 1); //supprimer la ligne
        array_splice($cart['id'],$idValue, 1); //supprimer la ligne
        array_splice($cart['title'],$idValue, 1); //supprimer la ligne
        array_splice($cart['price'],$idValue, 1); //supprimer la ligne
        array_splice($cart['image'],$idValue, 1); //supprimer la ligne


        $request->getSession()->set('cart', $cart);

        $request->getSession()->set('total_panier', $total);



        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/cart_valid", name="cart_valid")
     */
    public function validAction(Request $request)
    {
        //on donne à la variable cart la valeur du tableau de session cart
        //dump('coucou');die;

        return $this->render('Public/Cart/order.html.twig');
    }

    /**
     * @Route("/cart_remove", name="cart_remove")
     */
    public function removeAction(Request $request)
    {
        //on donne à la variable cart la valeur du tableau de session cart
        //dump('coucou');die;
        $request->getSession()->set('cart', []);
        $request->getSession()->set('total_panier', null);

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/cart_edit_qte/{id}", name="cart_edit_qte", requirements={"id" = "\d+"})
     */
    public function editQteAction($id, Request $request)
    {
        //récupération des valeurs en sessions
        $cart =  $request->getSession()->get('cart');
        $total =  $request->getSession()->get('total_panier');
        //recupération de la qte du submit
        $qte = $request->get('qte');
        //dump($cart, $total);

        //recherche de la position du produit modifié
        $idValue = array_search($id,$cart['id']);

        //supression du produit modifié dans le calcul total :
        $em = $this->getDoctrine()->getManager();
        $product_infos = $em->getRepository('AdminBundle:Product')->findProductById($id);
        $total = $total - ($product_infos['price']*$cart['qte'][$idValue]);
        //dump($total);
        //rajout du prix total pour le produit modifié
        $total = $total + ($product_infos['price']*$request->get('qte'));

        //dump($cart, $total);die;

        //modification de la quantité du produit modifié
        $cart['qte'][$idValue] = $qte;

        $request->getSession()->set('cart', $cart);
        $request->getSession()->set('total_panier', $total);

        return $this->redirect($request->headers->get('referer'));
    }
}