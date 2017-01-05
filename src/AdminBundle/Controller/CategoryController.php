<?php
/**
 * Created by PhpStorm.
 * User: wamobi14
 * Date: 04/01/17
 * Time: 16:42
 */

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CategoryController extends Controller
{
    /**
     * @Route("/categories", name="categories")
     */
    public function categoryAction()
    {
        $categories = [
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
        ];

        uasort($categories, array(__CLASS__,'trierParDate'));

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
}