<?php
/**
 * Created by PhpStorm.
 * User: hanzera
 * Date: 12/1/15
 * Time: 3:17 PM
 */

namespace StoreBundle\Controller;

use Sonata\AdminBundle\Controller\CoreController;
use Symfony\Component\Routing\Annotation\Route;
use StockBundle\Entity\Product;
use StockBundle\Entity\Image;
use StoreBundle\Form\ProductType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Imagick;

class ProductController extends CoreController
{
    /**
     * @Route("/admin/products/", name="view_products")
     */
    public function getProductsAction()
    {

        return $this->render('StoreBundle:Product:products.html.twig', array(
            'base_template'   => $this->getBaseTemplate(),
            'admin_pool'      => $this->container->get('sonata.admin.pool'),
            'blocks'          => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks')
        ));
    }

    /**
     * @Route("/admin/products/new", name="new_product")
     */
    public function addNewProductAction()
    {
        $product = new Product();

        $form = $this->createForm(new  ProductType(), $product);

        return $this->render('StoreBundle:Product:add_product.html.twig', array(
            'base_template'   => $this->getBaseTemplate(),
            'admin_pool'      => $this->container->get('sonata.admin.pool'),
            'blocks'          => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks'),
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/admin/products/{id}")
     */
    public function editProductAction($id)
    {
        $product = $this->getDoctrine()->getRepository('StockBundle:Product')->find($id);

        $form = $this->createForm(new  ProductType(), $product);

        return $this->render('StoreBundle:Product:edit_product.html.twig', array(
            'base_template'   => $this->getBaseTemplate(),
            'admin_pool'      => $this->container->get('sonata.admin.pool'),
            'blocks'          => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks'),
            'id' => $id,
            'form' => $form->createView(),
        ));
    }
}
