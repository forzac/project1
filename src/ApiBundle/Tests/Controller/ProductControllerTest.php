<?php
/**
 * Created by PhpStorm.
 * User: hanzera
 * Date: 12/10/15
 * Time: 11:45 AM
 */

namespace ApiBundle\Tests\Controller;

use StockBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use ApiBundle\Controller\ProductController;

class ProductControllerTest extends WebTestCase
{
    public function testGetProductsAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/products');

        // Утверждает что заголовок "Content-Type" - "application/json"
        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testGetProductAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/products/220');
        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testDeleteProductAction()
    {
        $client = static::createClient();

        $crawler = $client->request('DELETE', '/api/products/220');

        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }

    public function testNewProductAction()
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/api/products');
        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'));
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect());
    }

    public function testEditProductAction()
    {
        $client = static::createClient();

        $crawler = $client->request('PUT', '/api/products/220');
        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'));
        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        $this->assertTrue($client->getResponse()->isRedirect());
    }

    public function testUploadAction()
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/api/products/upload');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'));
    }

    public function testGetUploadAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/products/upload');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'));
    }

    public function testDeleteImageAction()
    {
        $client = static::createClient();

        $crawler = $client->request('DELETE', '/api/products/images/485');

        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }
}
