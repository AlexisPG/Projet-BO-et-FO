<?php
/**
 * Created by PhpStorm.
 * User: wamobi14
 * Date: 04/01/17
 * Time: 16:42
 */

namespace AdminBundle\Controller;

use AdminBundle\Entity\Category;

use AdminBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CategoryController extends Controller
{
    /**
     * @Route("/categories", name="categories")
     */
    public function categoryAction()
    {
        /*$categories = [
            1 => [
                "id" => 1,
                "title" => "Homme",
                "description" => "lorem ipsum \n suite du contenu",
                "date_created" => new \DateTime('now'),
                "active" => true
            ],
            2 => [
                "id" => 2,
                "title" => "Femme",
                "description" => "<strong>lorem</strong> ipsum",
                "date_created" => new \DateTime('-10 Days'),
                "active" => true
            ],
            3 => [
                "id" => 3,
                "title" => "Enfant",
                "description" => "Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un peintre anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n'a pas fait que survivre cinq siècles, mais s'est aussi adapté à la bureautique informatique, sans que son contenu n'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.",
                "date_created" => new \DateTime('-1 Days'),
                "active" => false
            ],
        ];*/

        // Affichage de toutes les catégories depuis la BDD via Entity/Category/Category.php
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository("AdminBundle:Category")->findAll();

/*        uasort($categories, array(__CLASS__,'trierParDate'));*/

        return $this->render('Category/categories.html.twig',
            [
                'categories' => $categories
            ]);
    }

    private static function trierParDate($a, $b) {
        if ($a['date_created'] == $b['date_created']) {
            return 0;
        }

        //return ($a['date_created'] < $b['date_created']) ? -1 : 1;

        if ($a['date_created'] > $b['date_created']) {
            return -1;
        } else {
            return 1;
        }
    }

    /**
     * @Route("/categories/creer", name="categories_create")
     */
    public function createCategoryAction(Request $request)
    {
        $category = new Category();

        // Création du formulaire CategoryType permettant de créer un produit
        // Je lie le formulaire à mon objet $product
        $formCategory = $this->createForm(CategoryType::class, $category);

        //l'objet sera hydraté à partir d'ici
        $formCategory->handleRequest($request);

        if ($formCategory->isSubmitted() && $formCategory->isValid())
        {
            /*die(dump($product));*/
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            //sauvegarde de la category
            $this->addFlash('success', 'Votre catégorie a bien été ajoutée');
            return $this->redirectToRoute('categories_create');
        }
        return $this->render('Category/create.html.twig',
            [
                'formCategory' =>$formCategory->createView()
            ]);
    }

    /**
     * @Route("/categories/{id}", name="show_category", requirements={"id" = "\d+"})
     * @ParamConverter("product", class="AdminBundle:Product")
     * Le param converter transforme la variable $id en object ($product) de la class Product
     */
    public function showCategoryAction(Product $product)
    {
        die(dump($product));

/*        Avec $id dans paramètre de public function showCategoryAction($id) // Affichage de toutes les catégories depuis la BDD via Entity/Category/Category.php

        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository("AdminBundle:Category")->find($id);

        // permet de gérer les exceptions pour les futures page 404
        if (empty($category)) {
            throw $this->createNotFoundException("La catégorie n'existe pas");
        }*/

        // LE BON ID ($id doit correspondre à un id existant dans $products)
        return $this->render('Category/show.html.twig',
            [
                'category' => $category
            ]);
    }





    /**
     * @Route("/categories/edit/{id}", name="edit_category", requirements={"id" = "\d+"})
     */
    public function editCategoryAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('AdminBundle:Category')->find($id);

        // Création du formulaire CategoryType permettant de créer une catégorie
        // Je lie le formulaire à mon objet $category
        $formCategory = $this->createForm(CategoryType::class, $category);

        // Je lie la requête ($_POST) à mon formulaire donc à mon objet $product
        $formCategory->handleRequest($request);

        // Je valide mon formulaire
        if ($formCategory->isSubmitted() && $formCategory->isValid()) {

            // La ligne ci-dessous n'est pas obligatoire car doctrine est au courant de l'existance de $product
            // $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'Votre catégorie a été mise à jour');

            return $this->redirectToRoute('show_category', ['id' => $id]);
        }

        return $this->render('Category/edit.html.twig', ['formCategory' => $formCategory->createView()]);
    }

    /**
     * @Route("/categories/supprimer/{id}", name="category_remove")
     */
    public function removeCategoryAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('AdminBundle:Category')->find($id);

        // Vérification si la catégorie est bien en BDD
        if (!$category) {
            throw $this->createNotFoundException("La catégorie n'existe pas");
        }

        $em->remove($category);
        $em->flush();
        $messageSuccess = 'Votre catégorie a été supprimé';
        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse(['message' => $messageSuccess]);
        }
        $this->addFlash('success', $messageSuccess);
        // Redirection sur la page qui liste tous les produits
        return $this->redirectToRoute('categories');
    }

    public function renderCategoriesAction() {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AdminBundle:Category')->findAll();
/*       die(dump($categories));*/

        return $this->render('Category/renderCategories.html.twig', ['categories' => $categories]);
    }


}