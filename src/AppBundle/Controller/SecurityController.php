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
    public function accessClientAction()
    {
        if($this->isGranted('ROLE_ADMIN'))
        {
            return new Response("
<h1>Visible par l'Admin</h1>

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
                ->setIsActive(false)
            ;


            // Pour préparer la requête
            $em->persist($data);
            // Pour envoyer la requête
            $em->flush();

            // Envoi du mail

            $message = \Swift_Message::newInstance()
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
            $this->get('mailer')->send($message);

            // Affichage d'un message de succes
            $this->addFlash('success', 'Votre email a bien été envoyé');

            return $this->redirectToRoute('security.login');
        }

        return $this->render("Public/Security/signup.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/mail_valid/{mail}/{token}", name="security.mail_valid")
     */
    public function mail_validAction($mail, $token)
    {
        //appel de doctrine pour la gestion bdd
        $doctrine = $this->getDoctrine();
        //chargement de em, indispensable pour le flush
        $em = $doctrine->getManager();
        //chargement de la table User dans la variable rcRole
        $rcRole = $doctrine->getRepository('AppBundle:User');
        //double test qui renvoi la ligne si les deux valeurs sont trouvées
        $user_compte = $rcRole->findOneBy([
            'email' => $mail,
            'token' => $token,
        ]);
        //dump('coucou');die;
        //vérification si la variable à un contenu
        if (isset($user_compte)) {
            //si oui compte active
            $user_compte->setisActive(true);
            //optionnel mais prépare le flush
            $em->persist($user_compte);
            //dump("bdd MAJ à venir");die;
            //mise à jour bdd
            $em->flush();

            //dump("bdd MAJ ok");die;

            //message de succès, qui sera affiché à la page appelée
            $this->addFlash('success', 'votre compte à bien été validé. Vous pouvez maintenant vous connecter');
            //appel de la page de connexion qui affichera le message de succès
            return $this->redirectToRoute('security.login');
            //renvoi sur la page de connexion avec message de compte validé
        } else { // si la varibale user_compte est null alors
            //recherche sur le mail seul
            $user_email = $rcRole->findOneBy([
                'email' => $mail,
            ]);
            //si le mail existe
            if (isset($user_email)) {
                //message d'erreur, préciser qu'il est possible de demander une nouvelle validation en demandant le  renvoi d'un mail.
            } else {//si le mail ,n'existe pas, c'est une tentative de violation de notre site, prévoir une page adaptée !
            }
        }

    }


}