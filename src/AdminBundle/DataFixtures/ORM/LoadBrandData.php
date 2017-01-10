<?php 
 
namespace AppBundle\DataFixtures\ORM;
 
use Doctrine\Common\Persistence\ObjectManager;
use AdminBundle\Entity\Brand;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadBrandData extends AbstractFixture implements OrderedFixtureInterface
{
     public function load(ObjectManager $manager)
     {

         for($i = 0; $i < 5; $i++)
         {
             $brand = new Brand();
             $brand->setTitle('un nouveau titre');

             $manager->persist($brand);
             $manager->flush();
             // création d'une variable afin de pouvoir relier un produit à une id brand existante
             $this->addReference('nouvelle-marque-'.$i, $brand);


             // php bin/console doctrine:fixtures:load     (Supprimer entièrement les informations de la BDD)
             // php bin/console doctrine:fixtures:load --append      (Supprimer entièrement les informations de la BDD)
         }
     }

    public function getOrder()
    {
        // Permet de choisir l'ordre d'execution des fixtures
        return 2;
    }
}