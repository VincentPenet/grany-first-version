<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PageControllerTest extends WebTestCase
{
    public function testHomePage()
    {
        // On crée un client à partir de la méthode createClient()
        $client = static::createClient();

        // On fait une requête à partir de ce client en méthode GET et on passe en deuxième paramètres l’URL, ici /
        $crawler = $client->request('GET', '/');

        // Pour vérifier que l’URl envoie bien une réponse 200
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testHomeCataloguePage()
    {
        // On crée un client à partir de la méthode createClient()
        $client = static::createClient();

        // On fait une requête à partir de ce client en méthode GET et on passe en deuxième paramètres l’URL, ici /
        $crawler = $client->request('GET', '/catalogue');

        // Pour vérifier que l’URl envoie bien une réponse 200
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
