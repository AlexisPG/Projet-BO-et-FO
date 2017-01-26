<?php
/**
 * Created by PhpStorm.
 * User: wamobi14
 * Date: 13/01/17
 * Time: 16:25
 */

namespace AppBundle\Controller;

use AppBundle\Form\UserType;
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

    public function editProfileActions(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        // Création du formulaire UserType permettant de créer un user
        // Je lie le formulaire à mon objet $user
        $formUser = $this->createForm(UserType::class, $user);

        // Je lie la requête ($_POST) à mon formulaire donc à mon objet $product
        $formUser->handleRequest($request);

        // Je valide mon formulaire
        if ($formUser->isSubmitted() && $formUser->isValid()) {

            // La ligne ci-dessous n'est pas obligatoire car doctrine est au courant de l'existance de $product
            // $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Votre profile a été mis à jour');

            return $this->redirectToRoute('profile.index');
        }

        return $this->render('Public/User/edit.html.twig',
            [
                'form' => $formUser->createView()
            ]);

        return $this->render('Public/User/edit.html.twig');
    }
}