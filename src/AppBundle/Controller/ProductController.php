<?php
/**
 * Created by PhpStorm.
 * User: wamobi14
 * Date: 13/01/17
 * Time: 16:25
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{

    /**
     * @Route("/produit/{id}", name="voir_produit", requirements={"id" = "\d+"})
     */

    public function ProductsActions($id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository("AdminBundle:Product")->find($id);

        // permet de gérer le s"exceptions pour les futurs page 404
        if (empty($product)) {
            throw $this->createNotFoundException("Le produit n'existe pas");
        }

        // LE BON ID ($id doit correspondre à un id existant dans $products)
        return $this->render('Public/Products/show.html.twig',
            [
                'product' => $product
            ]);
    }

    public function findAllProductFromCategorie()
    {
        // TODO : terminer la requete des produits de la catégorie
    }
}