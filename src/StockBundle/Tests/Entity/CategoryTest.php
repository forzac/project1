<?php
/**
 * Created by PhpStorm.
 * User: hanzera
 * Date: 12/11/15
 * Time: 1:11 PM
 */

namespace StockBundle\Tests\Entity;

use StockBundle\Entity\Category;
use StockBundle\Entity\Product;


class CategoryTest extends \PHPUnit_Framework_TestCase
{
    public function testSetName()
    {
        $category = new Category();

        $category->setName('New');
        $this->assertEquals('New', $category->getName());
    }

    public function testSetProducts()
    {
        $category = new Category();

        $category->setProducts('AAA');
        $this->assertEquals('AAA', $category->getProducts());
    }
}
