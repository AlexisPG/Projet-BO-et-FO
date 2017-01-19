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


/**
 * @Route("/{_locale}")
 */

class TranslationController extends Controller
{

    /**
     * @Route("/translation", name="translation.index")
     */

    public function indexActions(Request $request)
    {
        $locale = $request->getLocale();
        $doctrine = $this->getDoctrine();
/*        $result = $doctrine
            ->getRepository('AdminBundle:Product')
            ->findProductByLocale(1, $locale);

        dump($result); exit;*/

        $result = $doctrine
            ->getRepository("AdminBundle:Product")
            ->find(1);

        return $this ->render('Public/Translation/index.html.twig',
            [
                'result' => $result
            ]);
    }
}