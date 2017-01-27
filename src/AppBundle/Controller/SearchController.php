<?php
/**
 * Created by PhpStorm.
 * User: wamobi14
 * Date: 27/01/17
 * Time: 15:10
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class SearchController extends Controller
{
    /**
     * @Route("/search", name="search.index",)
     */

    public function indexActions(Request $request)
    {

        return $this->render('Public/Search/index.html.twig');
    }

    /**
     * @Route("/search-ajax", name="search-ajax",)
     */

    public function searchAjActions(Request $request)
    {

        $data = $request->get("data");

        $doctrine = $this->getDoctrine();
        $results = $doctrine->getRepository('AdminBundle:Product')->searchByName($data);

        return new JsonResponse($results);
    }
}