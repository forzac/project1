<?php
/**
 * Created by PhpStorm.
 * User: hanzera
 * Date: 11/30/15
 * Time: 9:59 AM
 */

namespace StoreBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sonata\AdminBundle\Controller\CoreController;

class MainController extends CoreController
{
    /**
     * @Route("/admin/main", name="main")
     */
    public function mainAction()
    {

        return $this->render('StoreBundle:Main:admin_main.html.twig', array(
            'base_template'   => $this->getBaseTemplate(),
            'admin_pool'      => $this->container->get('sonata.admin.pool'),
            'blocks'          => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks')
        ));
    }
}
