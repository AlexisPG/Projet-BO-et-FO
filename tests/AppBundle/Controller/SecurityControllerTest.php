<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testSignUp()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/signup');
        $container = $client->getContainer();

// TEST du fonctionnement
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Création de compte', $crawler->filter('h1')->text());

        // Test du formulaire
        // On sélection le bouton

        $username = 'username' . time();
        $password = 'password' . time();
        $email = 'email' . time() . '@mail.com';
        $bday = strlen(new \DateTime('d/m/Y'));


        $form = $crawler->selectButton('submit')->form([
            'appbundle_user[username]' => $username,
            'appbundle_user[password]' => $password,
            'appbundle_user[email]' => $email,
        ]);

        $form['avatar']->upload('/upload/hey.png');


        // On soumet le formulaire
        $crawler = $client->submit($form);
    }
}
