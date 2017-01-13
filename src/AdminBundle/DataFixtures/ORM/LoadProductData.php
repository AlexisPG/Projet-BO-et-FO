<?php 
 
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use AdminBundle\Entity\Product;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadProductData extends AbstractFixture implements OrderedFixtureInterface
{
     public function load(ObjectManager $manager)
     {
         $arrayBrand = [];
         for ($i = 0; $i < 5; $i++) {
             $arrayBrand[] = $this->getReference('nouvelle-marque-'.$i);

         }

         for($i = 0; $i < 50; $i++)
         {
             $product = new Product();
             $product->setTitle('un nouveau titre')
                 ->setDescription('Nouveau produit super top')
                 ->setPrice(rand(1,1000))
                 ->setQuantity(rand(1,100))
                 ->setMarque($this->getReference('nouvelle-marque-'.$i));

             /* Equivaut à la ligne ci-dessus
             $brand = $this->getReference('nouvelle-marque');
             //die(dump($brand));
             $product->setMarque($brand);
              */

             $manager->persist($product);
             $manager->flush();

                 // php bin/console doctrine:fixtures:load     (Supprimer entièrement les informations de la BDD)
                 // php bin/console doctrine:fixtures:load --append      (Supprimer entièrement les informations de la BDD)
         }
     }

    public function getOrder()
    {
        // Permet de choisir l'ordre d'execution des fixtures
        return 3;
    }
}