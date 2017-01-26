<?php

namespace AdminBundle\Controller;


use AppBundle\Event\VisitContactEvent;
use AppBundle\Event\VisitEvents;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="welcome.symfony")
     */
    public function indexAction()
    {
/*      $em = $this->getDoctrine()->getManager();
        $tousLesProduits = $em->getRepository('AdminBundle:Product')->myFind($id);*/ // a ce moment, il y a un $id qui devra etre dans indexAction($id)

        // Lien avec BDD
        // Affichage de tous les produits depuis la BDD via Entity/Product/Product.php
        $em = $this->getDoctrine()->getManager();
        /*$em->getRepository('AdminBundle:Product')->myFindQuantityInf5();*/
        /*$em->getRepository('AdminBundle:Product')->myFindCountQuantity0();*/
        $doctrine = $this->getDoctrine();
        $rc = $doctrine->getRepository('AdminBundle:Product');
        /*$results = $rc->findProduct();*/
        $results = $rc->findProduct2();

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
            ->add('firstname', TextType::class, [
                'constraints' =>
                    [
                        new Assert\NotBlank(['message' => 'Veuillez rentrer votre prénom']),
                        new Assert\Length([
                            'min' => 2,
                            'minMessage' => 'Your first name must be at least {{ limit }} characters long'
                        ])
                    ]
            ])
            ->add('lastname', TextType::class, [
                'constraints' =>
                    [
                        new Assert\NotBlank(['message' => 'Veuillez rentrer votre nom'])
                    ]
            ])
            ->add('email', EmailType::class, [
                'constraints' =>
                    [
                        new Assert\NotBlank(['message' => 'Veuillez rentrer un email']),
                        new Assert\Email([
                            'message' => 'Votre email {{ value }} est faux'
                        ])
                    ]
            ])
            ->add('content', TextareaType::class, [
                'constraints' =>
                    [
                        new Assert\NotBlank(['message' => 'Veuillez rentrer votre message']),
                        new Assert\Length([
                            'max' => 50,
                            'maxMessage' => 'Votre message doit avoir {{ limit }} caractères minimum'
                        ])
                    ]
            ])
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

        $choice = [
            "technique" => "1",
            "design" => "2",
            "marketing" => "3",
            "autre" => "4",
        ];

        $formFeedback = $this->createFormBuilder()
            ->add('page', TextType::class, [
                'constraints' =>
                    [
                        new Assert\NotBlank(['message' => 'Veuillez indiquer une page de feedback']),
                        new Assert\Url(['message' => 'Veuillez indiquer une page valide, car {{ value }} n\'est pas au bon format.'])
                    ]
            ])
            ->add('bug', ChoiceType::class,
                [
                    "choices" => $choice
                ],
                [
                    'constraints' => [
                        new Assert\NotBlank(['message' => 'Veuillez sélectionner un choix']),
                        new Assert\Choice([
                            'choices' => $choice,
                            'message' => 'Attention'
                        ])
                    ]
                ]
            )
            ->add('firstname', TextType::class,
                [
                    'constraints' => [
                        new Assert\NotBlank(['message' => 'Veuillez rentrer votre prénom'])
                    ]
                ]
            )
            ->add('lastname', TextType::class,
                [
                    'constraints' => [
                        new Assert\NotBlank(['message' => 'Veuillez rentrer votre nom'])
                    ]
                ]
            )
            ->add('email', EmailType::class, [
                'constraints' =>
                    [
                        new Assert\NotBlank(['message' => 'Veuillez rentrer un email']),
                        new Assert\Email([
                            'message' => 'Votre emaoil {{ value }} est faux'
                        ])
                    ]
            ])

            // ------------DATE
            // La clé years permet de définir un tableau d'années
            // range créer un tableau : http://php.net/manual/fr/function.range.php
            // date('Y') donne l'année en cours. Ici 2017
            // date('Y') - 10 est l'équivalent de 2017 - 10 = 2007
            ->add('date', DateType::class,
                [
                    "widget" => "single_text",
                    "html5" => false,
                    // 'years' => range( date('Y')-10, date('Y')+10 ),
                    'format' => 'dd-MMMM-yyyy'
                ],
                [
                    'constraints' => [
                        new Assert\NotBlank(['message' => 'Veuillez rentrer une date'])
                    ]
                ]
            )
            ->add('content', TextareaType::class,
                [
                    'constraints' => [
                        new Assert\NotBlank(['message' => 'Veuillez rentrer votre message']),
                        new Assert\Length([
                            'min' => 10,
                            'minMessage' => 'Votre message doit avoir {{ limit }} caractères minimum',
                            'max' => 50,
                            'maxMessage' => 'Votre message doit avoir {{ limit }} caractères max'
                        ]),
                        new Assert\Regex([

                            'pattern' => '/\b(hello|je)\b/',
                            'match' => false,
                            'message' => 'Merci de modérer vos propos',
                        ])

                    ]
                ]
            )
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
