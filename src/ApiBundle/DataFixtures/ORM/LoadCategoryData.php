<?php
/**
 * Created by PhpStorm.
 * User: hanzera
 * Date: 11/26/15
 * Time: 3:44 PM
 */

namespace ApiBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\Persistence\ObjectManager;
use StockBundle\Entity\Category;

class LoadCategoryData implements  FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $mobile = new Category();
        $mobile->setName('mobile');

        $mouse = new Category();
        $mouse->setName('mosue');

        $manager->persist($mobile);
        $manager->persist($mouse);

        $manager->flush();
    }
}