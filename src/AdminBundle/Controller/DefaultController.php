<?php

namespace AdminBundle\Controller;


use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('Default/index.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     * Liste des éléments pour les formulaire : https://symfony.com/doc/current/reference/forms/types.html
     */
    public function contactAction(Request $request)
    {
        // Création du formulaire et ajoute de champ avec la méthode add()
        $formContact = $this->createFormBuilder()
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('email', EmailType::class)
            ->add('content', TextareaType::class)
            ->getForm();

        // Je lie l'objet $request avec le formulaire.
        // Cela me permet de remplir le formulaire avec les informations tapées par l'utilisateur
        $formContact->handleRequest($request);

        // Je vérifie que le formulaire est bien soumis et qu'il est valide
        if ($formContact->isSubmitted() && $formContact->isValid()) {
            /*            // Dump de $_POST
                        dump($request->request->all());

                        // Dump de $_POST['firstname']
                        dump($request->request->get('firstname'));

                        // Dump de $_GET
                        dump($request->query->all());

                        // Récupérer les informations du formulaire
                        dump($formContact->getData());

                        // Récupérer une valeur précisément du formulaire
                        dump($formContact->get('firstname')->getData());*/

            // La technique à utiliser est d'utiliser une variable ex: $data et de manipuler cette variable
            $data = $formContact->getData();

            // Envoie du mail
            $message = \Swift_Message::newInstance()
                ->setSubject('Formulaire de contact')
                ->setFrom($data['email'])
                ->setTo('contact@monsupersite.com')
                ->setBody
                (
                    $this->renderView('Emails/formulaire-contact.html.twig',
                        [
                            'data' => $data
                        ]),
                    'text/html'
                )
/*
                ->setBody(
                    $this->renderView('Emails/formulaire-contact.html.twig',
                        [
                            'firstname' => ($data['firstname']),
                            'lastname' => ($data['lastname']),
                            'email' => ($data['email']),
                            'content' => ($data['content']),
                        ]),
                    'text/html'
                )
*/
                ->addPart(
                    $this->renderView('Emails/formulaire-contact.txt.twig',
                    [
                        'data' => $data
                    ]),
                    'text/plain'
                );
            $this->get('mailer')->send($message);

            // Affichage d'un message de succes
            $this->addFlash('success', 'Votre email a bien été envoyé');

            //Redirection : Préciser le nom de la route dans la méthode 'redirectToRoute
            return $this->redirectToRoute('contact');

        }
        return $this->render('Default/contact.html.twig',
            [
                "formContact" => $formContact->createView()
            ]);
    }

    /**
     * @Route("/feedback", name="feedback")
     */
    public function feedbackAction(Request $request)
    {
        $formFeedback = $this->createFormBuilder()
            ->add('page', TextType::class)
            ->add('bug', ChoiceType::class, array(
                "choices" => array(
                    "technique" => "1",
                    "design" => "2",
                    "marketing" => "3",
                    "autre" => "4",
                )
            ))
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('email', EmailType::class)
            // La clé years permet de définir un tableau d'années
            // range créer un tableau : http://php.net/manual/fr/function.range.php
            // date('Y') donne l'année en cours. Ici 2017
            // date('Y') - 10 est l'équivalent de 2017 - 10 = 2007
            ->add('date', DateType::class,
                [
                    "widget" => "single_text",
                    "html5" => false
                    // 'years' => range( date('Y')-10, date('Y')+10 ),
                    // 'format' => 'dd-MMMM-yyyy'
                ])
            ->add('content', TextareaType::class)
            ->getForm();

        // Je lie l'objet $request avec le formulaire.
        // Cela me permet de remplir le formulaire avec les informations tapées par l'utilisateur
        $formFeedback->handleRequest($request);

        // Je vérifie que le formulaire est bien soumis et qu'il est valide
        if ($formFeedback->isSubmitted() && $formFeedback->isValid()) {

            // La technique à utiliser est d'utiliser une variable ex: $data et de manipuler cette variable
            $data = $formFeedback->getData();

            // Envoie du mail
            $message = \Swift_Message::newInstance()
                ->setSubject('Formulaire de Feedback')
                ->setFrom($data['email'])
                ->setTo('contact@monsupersite.com')
                ->setBody
                (
                    $this->renderView('Emails/formulaire-feedback.html.twig',
                        [
                            'data' => $data
                        ]),
                    'text/html'
                )

                ->addPart(
                    $this->renderView('Emails/formulaire-feedback.txt.twig',
                        [
                            'data' => $data
                        ]),
                    'text/plain'
                );
            $this->get('mailer')->send($message);

            // Affichage d'un message de succes
            $this->addFlash('success', $data['firstname']. ', votre email a bien été envoyé');

            //Redirection : Préciser le nom de la route dans la méthode 'redirectToRoute
            return $this->redirectToRoute('feedback');

        }
        return $this->render('Default/feedback.html.twig',
            [
                "formFeedback" => $formFeedback->createView()
            ]);
    }
}
