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

class CategoryController extends Controller
{

    /**
     * @Route("/categorie/{id}", name="voir_categorie", requirements={"id" = "\d+"})
     */

    public function CategoryActions($id)
    {
        $em = $this->getDoctrine()->getManager();

        // Requete amenant vers 1 catégorie spécifique
        $category = $em->getRepository("AdminBundle:Category")->find($id);

        // permet de gérer le s"exceptions pour les futures page 404
        if (empty($category)) {
            throw $this->createNotFoundException("La catégorie n'existe pas");
        }

        // Requetes renvoyant tous les produits de la catégorie
        $products = $em->getRepository("AdminBundle:Product")->findAllProductFromCategorie();
        // TODO: terminer la requete des produits de la catégorie

        // LE BON ID ($id doit correspondre à un id existant dans $products)
        return $this->render('Public/Category/show.html.twig',
            [
                'category' => $category,
                'products' => $products

            ]);
    }
}