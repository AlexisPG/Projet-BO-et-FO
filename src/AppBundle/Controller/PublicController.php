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

class PublicController extends Controller
{

    /**
     * @Route("/public", name="public_homepage")
     */
    public function PublicActions()
    {
        // Afficher les 6 derniers produits les plus chers par ordre décroissant de prix
        $em = $this->getDoctrine();
        $query = $em->getRepository("AdminBundle:Product");
        $products = $query->findLastSixProducts();

        $sliders = $query->findTreeSliders();

        return $this->render('Public/Main/index.html.twig', [
            "products" => $products,
            "sliders" => $sliders
        ]);
    }

    public function renderCategoriesAction()
    {
        $em = $this->getDoctrine();
        $query = $em->getRepository("AdminBundle:Category");
        $categories = $query->displayCategories();

        return $this->render('Public/Category/renderCategories.html.twig', [
            "categories" => $categories,
        ]);
    }
}