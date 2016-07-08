<?php
/**
 * Created by PhpStorm.
 * User: hanzera
 * Date: 12/11/15
 * Time: 3:32 PM
 */

namespace StockBundle\Tests\Entity;

use StockBundle\Entity\Product;
use StockBundle\Entity\Category;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    public function testSetName()
    {
        $product = new Product();

        $product->setName('New Product');
        $this->assertEquals('New Product', $product->getName());
    }

    public function testSetQuantity()
    {
        $product = new Product();

        $product->setQuantity(1);
        $this->assertEquals(1, $product->getQuantity());
    }

    public function testSetDescription()
    {
        $product = new Product();

        $product->setDescription('New Products');
        $this->assertEquals('New Products', $product->getDescription());
    }

    public function testSetCategory()
    {
        $product = new Product();
        $category = new Category();

        $product->setCategory($category);
        $this->assertEquals($category, $product->getCategory());
    }
}
