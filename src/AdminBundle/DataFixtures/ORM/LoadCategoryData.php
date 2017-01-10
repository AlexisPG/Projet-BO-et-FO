<?php 
 
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use AdminBundle\Entity\Category;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
     public function load(ObjectManager $manager)
     {
         for($i = 0; $i < 5; $i++)
         {
             $category = new Category();
             $category->setTitle('un nouveau titre')
                 ->setDescription('Catégorie - '.$i)
                 ->setPosition(rand(1,63))
                ->setActive(true);

             $manager->persist($category);
             $manager->flush();

             // php bin/console doctrine:fixtures:load     (Supprimer entièrement les informations de la BDD)
             // php bin/console doctrine:fixtures:load --append      (Supprimer entièrement les informations de la BDD)
         }
     }
    public function getOrder()
    {
        // Permet de choisir l'ordre d'execution des fixtures
        return 1;
    }
}