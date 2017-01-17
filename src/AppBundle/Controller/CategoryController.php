<?php
/**
 * Created by PhpStorm.
 * User: wamobi14
 * Date: 13/01/17
 * Time: 16:25
 */

namespace AppBundle\Controller;

use AdminBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{

    /**
     * @Route("/categorie/{id}/{page}",
     *     name="voir_categorie",
     *     requirements={"id" = "\d+", "page" = "\d+"},
     *     defaults={"page"=1}
     *  )
     */

    public function CategoryActions($id, $page, Category $category, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // Requete amenant vers 1 catégorie spécifique
        $category = $em->getRepository("AdminBundle:Category")->find($id);

        // Permet de gérer lesexceptions pour les futures page 404
        if (empty($category)) {
            throw $this->createNotFoundException("La catégorie n'existe pas");
        }



        // Gestion de la pagination
        $offset = ($page - 1) * 4;

        $nbrePage = ceil($em->getRepository('AdminBundle:Product')->countProductByCategory($id) / 4);

        // Requete renvoyant tous les produits de la catégorie
  	    $products = $em->getRepository('AdminBundle:Product')->findAllProductFromCategory($id, $offset);



        // LE BON ID ($id doit correspondre à un id existant dans $products)
        return $this->render('Public/Category/show.html.twig',
            [
                'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
                'category' => $category,
                'products' => $products,
                'pages' => $nbrePage,
                "pageActive" => $page
            ]);
    }
}