<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ProductController extends Controller
{
    /**
     * @Route("/products", name="products")
     */
    public function productAction()
    {
        $products = [
            [
                "id" => 1,
                "title" => "Mon premier produit",
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

        // Moyenne des prix
        $product_Sum = 0;
        foreach ($products as $p)
        {
            $product_Sum = $product_Sum + $p["prix"];
        }


        return $this->render('Product/tousLesProduits.html.twig',
            [
                'products' => $products,
                'product_Sum' => $product_Sum
            ]);
    }



    /**
     * @Route("/products/{id}", name="show_product", requirements={"id" = "\d+"})
     */
    public function showAction($id)
    {
        $products = [
            [
                "id" => 1,
                "title" => "Mon premier produit",
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
        // Permet de faire le bon lien sur le bon ID en cliquant sur "voir"
        $leBonProduit = [];
        foreach ($products as $p)
        {
            if($id == $p['id'])
            {
                $leBonProduit = $p;
                break;
            }
        }
        // permet de gérer le s"exceptions pour les futurs page 404
        if (empty($leBonProduit)) {
            throw $this->createNotFoundException("Le produit n'existe pas");
        }

        // TROUVER LE MOYEN D'ENVOYER UNIQUEMENT LE PRODUIT AYANT
        // LE BON ID ($id doit correspondre à un id existant dans $products)
        return $this->render('Product/show.html.twig',
            [
                'products' => $products,
                'leproduit' => $leBonProduit
            ]);
    }
}
