<?php
/**
 * Created by PhpStorm.
 * User: hanzera
 * Date: 12/11/15
 * Time: 6:22 PM
 */

namespace ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    public function testGetCategoriesAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/categories');

        // Утверждает что заголовок "Content-Type" - "application/json"
        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'));

        // Утверждает что статус-код ответа точно 200
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testDeleteCategoryAction()
    {
        $client = static::createClient();

        $crawler = $client->request('DELETE', '/api/categories/101');

        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }

    public function testNewCategoryAction()
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/api/categories');
        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'));
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect());
    }

    public function testEditCategoryAction()
    {
        $client = static::createClient();

        $crawler = $client->request('PUT', '/api/categories/100');
        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'));
        $this->assertEquals(204, $client->getResponse()->getStatusCode());

        $this->assertTrue($client->getResponse()->isRedirect());
    }
}
