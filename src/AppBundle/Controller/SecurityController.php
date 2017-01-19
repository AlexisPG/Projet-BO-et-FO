<?php
/**
 * Created by PhpStorm.
 * User: wamobi15
 * Date: 17/01/17
 * Time: 16:07
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;


class SecurityController extends Controller
{

    /**
     * @Route("/acces-client", name="security.acces-client")
     */
    public function accesClientAction()
    {
        if($this->isGranted('ROLE_ADMIN'))
        {
            return new Response("
<h1>Visible par l'Admin</h1>
<h2>Hey ouai mec ;)</h2>
");
        }
        else
        {
            return new Response("<h1>Vous êtes un client / user</h1>");
        }
    }

    /**
     * @Route("/login", name="security.login")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('Public/Security/security.login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @Route("/logout", name="security.logout")
     */
    public function logoutAction()
    {
    }

    /**
     * @Route("/signup", name="signup")
     */
    public function signUptAction(Request $request)
    {
        $entity = new User();
        $entityType = UserType::class;

        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();

        $rcRole = $doctrine->getRepository('AppBundle:Role');

        $form = $this->createForm($entityType, $entity);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();
            $encodePassword = $this->get('security.password_encoder');
            $password = $encodePassword->encodePassword($data, $data->getPassword());
            $data->setpassword($password);

            $role = $rcRole->findOneBy([
                'name' =>'ROLE_USER'
            ]);
            $data->addRole($role);

            // Ajout du Token en BDD
            // Comme si c'était une new(), mais pour le token
            $serviceToken = $this->get('admin.service.utils.strings');
            // Génération d'un token aléatoire
            $token = $serviceToken->generateUniqId();
            // Assignation du token et de ISActive A à 0 à l'utilisateur
            $data
                ->setToken($token)
                ->setIsActive(0)
            ;


            // Pour préparer la requête
            $em->persist($data);
            // Pour envoyer la requête
            $em->flush();

            // Envoi du mail

/*            $message = \Swift_Message::newInstance()
                ->setSubject('Formulaire de création de compte')
                ->setFrom($data->getEmail())
                ->setTo('contact@monsupersite.com')
                ->setBody
                (
                    $this->renderView('Public/Emails/formulaire-signup.html.twig',
                        [
                            'data' => $data
                        ]),
                    'text/html'
                )

                ->addPart(
                    $this->renderView('Public/Emails/formulaire-signup.txt.twig',
                        [
                            'data' => $data
                        ]),
                    'text/plain'
                );
            $this->get('mailer')->send($message);*/

            // Affichage d'un message de succes
            $this->addFlash('success', 'Votre email a bien été envoyé');

            return $this->redirectToRoute('security.login');
        }

        return $this->render("Public/Security/signup.html.twig", [
            'form' => $form->createView()
        ]);
    }


}