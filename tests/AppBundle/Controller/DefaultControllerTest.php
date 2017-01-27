<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $container = $client->getContainer();

// TEST
//        $this->assertEquals(200, $client->getResponse()->getStatusCode());
//        $this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());
        $this->assertGreaterThan(2, $crawler->filter('h1 ul li')->count());

        // Test 1 : Depuis la page "/" > page "/public" via Accéder au site public
        $link = $crawler->selectLink('Accéder au site public')->link();
        $crawler = $client->click($link);


        // Test 2 : Depuis la page "/public" > page "/order" via Commander mon panier
        //$crawler = $client->request('GET', '/');
        $link = $crawler->selectLink('Pulls')->link();
        $crawler = $client->click($link);

        // On peut mettre un DUMP pour voir ce qu'il y a derrière la page
//

    }
}
