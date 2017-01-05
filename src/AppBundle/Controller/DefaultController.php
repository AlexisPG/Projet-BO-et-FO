<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
      $firstname = "Alexis";
        // replace this example code with whatever you need
        return $this->render('default-old//index.html.twig', [
          'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
          "firstname" => $firstname
        ]);
    }

    /**
     * @Route("/contact", name="contact-old")
     */

    public function contactAction(Request $request)
    {
      $firstname = "Alexis";
      // dump($firstname);
      // die("end");
      return $this->render('default-old//contact.html.twig', [
        "firstname" => $firstname
          ]);

    }

        /**
     * @Route("/product", name="product-test")
     */

    public function productAction(Request $request)
    {
        $products = [
    [
        "id" => 1,
        "title" => "mon premier produit",
        "description" => "lorem ipsum",
        "date_created" => new \DateTime('now'),
        "prix" => 10
    ],
    [
        "id" => 2,
        "title" => "Mon deuxième produit",
        "description" => "lorem ipsum",
        "date_created" => new \DateTime('now'),
        "prix" => 20
    ],
    [
        "id" => 3,
        "title" => "Mon troisième produit",
        "description" => "lorem ipsum",
        "date_created" => new \DateTime('now'),
        "prix" => 30
    ],
    [
        "id" => 4,
        "title" => "",
        "description" => "lorem ipsum",
        "date_created" => new \DateTime('now'),
        "prix" => 410
    ],
    ];
    $prenom = "Alexis";
    $nom = "Persinette";

      return $this->render('default/product.html.twig', [
        "products" => $products,
        "prenom" => $prenom,
        "nom" => $nom

          ]);
    }

    /**
     * @Route("/bloc-mere", name="bloc-mere")
     */

    public function blocMereAction(Request $request)
    {

      return $this->render('default-old//bloc-mere.html.twig', [
          ]);

    }

    /**
     * @Route("/bloc-fille", name="bloc-fille")
     */

    public function blocFilleAction(Request $request)
    {

      return $this->render('default-old//bloc-fille.html.twig', [
          ]);

    }
    /**
     * @Route("/bloc-frere", name="bloc-frere")
     */

    public function blocFrereAction(Request $request)
    {

      return $this->render('default-old//bloc-frere.html.twig', [
          ]);

    }
}
