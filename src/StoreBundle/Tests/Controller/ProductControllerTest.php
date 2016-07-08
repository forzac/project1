<?php
/**
 * Created by PhpStorm.
 * User: hanzera
 * Date: 12/11/15
 * Time: 4:54 PM
 */

namespace StoreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testGetProductsAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/products');

        // Утверждает что статус-код ответа точно 301
        $this->assertEquals(301, $client->getResponse()->getStatusCode());
    }
}