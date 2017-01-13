<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Product;
use AdminBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class ProductController extends Controller
{
    /**
     * @Route("/products/creer", name="products_create")
     */
    public function createAction(Request $request)
    {
        $product = new Product();
        /*Permet de mettre du contenu dans le champs title*/
        /*$product->setTitle("hello");*/
        /*dump($product);*/


        // Création du formulaire ProductType permettant de créer un produit
        // Je lie le formulaire à mon objet $product
        $formProduct = $this->createForm(ProductType::class, $product);

        //l'objet sera hydraté à partir d'ici
        $formProduct->handleRequest($request);

        if ($formProduct->isSubmitted() && $formProduct->isValid())
        {
            //Sauvegarde du produit
            $em = $this->getDoctrine()->getManager();

            /*// Récupération de l'image
            $image = $product->getImage();*/

/*            // service utils
            $serviceUtils = $this->get('admin.service.utils.strings');
            $filename = $serviceUtils->generateUniqId() . '-'. $product->getTitle() . '.' .$image->guessExtension();

            // Transfert d'image
            $image->move('upload/', $filename);*/

            /*// Nom unique dans la BDD
            $uploadService = $this->get('admin.service.upload');
            $name = $uploadService->upload($image);

            // insertion du nom du fichier image généré dans notre objet produit
            $product->setImage($name);*/

            //$product = $this->UploadService();
            // Pour préarer la requête
            $em->persist($product);

            // Pour envoyer la requête
            $em->flush();

            //sauvegarde du produit
            $this->addFlash('success', 'Votre produit a bien été ajouté');
            return $this->redirectToRoute('products_create');
        }
        return $this->render('Product/create.html.twig',
            [
                'formProduct' =>$formProduct->createView()
            ]);
    }


    /**
     * @Route("/products", name="products")
     */
    public function productAction()
    {
            /*TABLEAU de product de test
        $products =

             * [
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
        ];*/

        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository("AdminBundle:Product")->findAll();
/*        die(dump($products));*/

        // Moyenne des prix
        $product_Sum = 0;
        foreach ($products as $p)
        {
            $product_Sum = $product_Sum + $p->getPrice();
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
        /*$products = [
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
        ];*/
        // Affichage de tous les produits depuis la BDD via Entity/Product/Product.php

        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository("AdminBundle:Product")->find($id);

/*
        // Permet de faire le bon lien sur le bon ID en cliquant sur "voir"
        $leBonProduit = [];
        foreach ($product as $p)
        {
            if($id == $p['id'])
            {
                $leBonProduit = $p;
                break;
            }
        }
*/
        // permet de gérer le s"exceptions pour les futurs page 404
        if (empty($product)) {
            throw $this->createNotFoundException("Le produit n'existe pas");
        }

        // LE BON ID ($id doit correspondre à un id existant dans $products)
        return $this->render('Product/show.html.twig',
            [
                'product' => $product
            ]);
    }

    /**
     * @Route("/products/edit/{id}", name="edit", requirements={"id" = "\d+"})
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('AdminBundle:Product')->find($id);

        // Création du formulaire ProductType permettant de créer un produit
        // Je lie le formulaire à mon objet $product
        $formProduct = $this->createForm(ProductType::class, $product);

        // Je lie la requête ($_POST) à mon formulaire donc à mon objet $product
        $formProduct->handleRequest($request);

        // Je valide mon formulaire
        if ($formProduct->isSubmitted() && $formProduct->isValid()) {

            // La ligne ci-dessous n'est pas obligatoire car doctrine est au courant de l'existance de $product
            // $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Votre produit a été mis à jour');

            return $this->redirectToRoute('show_product', ['id' => $id]);
        }

        return $this->render('Product/edit.html.twig',
            [
                'formProduct' => $formProduct->createView()
            ]);
    }

    /**
     * @Route("/products/supprimer/{id}", name="product_remove")
     */
    public function removeAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('AdminBundle:Product')->find($id);

        // Vérification si le produit est bien en BDD
        if (!$product) {
            throw $this->createNotFoundException("Le produit n'existe pas");
        }

        $em->remove($product);
        $em->flush();
        $messageSuccess = 'Votre produit a été supprimé';
        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse(['message' => $messageSuccess]);
        }

        $this->addFlash('success', $messageSuccess);
        // Redirection sur la page qui liste tous les produits
        return $this->redirectToRoute('products');
    }
}
