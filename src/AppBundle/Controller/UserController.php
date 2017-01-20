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


class UserController extends Controller
{
    /**
     * @Route("/profile", name="profile.index")
     */

    public function indexActions()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        return $this->render('Public/User/index.html.twig');
    }

    /**
     * @Route("/profile/edit", name="profile.edit")
     */

    public function editProfileActions()
    {
        return $this->render('Public/User/edit.html.twig');
    }
}