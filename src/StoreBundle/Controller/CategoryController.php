<?php
/**
 * Created by PhpStorm.
 * User: hanzera
 * Date: 11/27/15
 * Time: 3:38 PM
 */

namespace StoreBundle\Controller;

use StockBundle\Entity\Category;
use StoreBundle\Form\CategoryType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sonata\AdminBundle\Controller\CoreController;

class CategoryController extends CoreController
{

    /**
     * @Route("/admin/categories", name="view_category")
     */
    public function getCategoriesAction()
    {

        return $this->render('StoreBundle:Category:categories.html.twig', array(
            'base_template'   => $this->getBaseTemplate(),
            'admin_pool'      => $this->container->get('sonata.admin.pool'),
            'blocks'          => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks')
        ));
    }

    /**
     * @Route("/admin/categories/new", name="new_category")
     */
    public function addNewCategoryAction()
    {
        $category = new Category();

        $form = $this->createForm(new  CategoryType(), $category);

        return $this->render('StoreBundle:Category:add_category.html.twig', array(
            'base_template'   => $this->getBaseTemplate(),
            'admin_pool'      => $this->container->get('sonata.admin.pool'),
            'blocks'          => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks'),
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/admin/categories/{id}")
     */
    public function editCategoryAction($id)
    {
        $category = $this->getDoctrine()->getRepository('StockBundle:Category')->find($id);

        $form = $this->createForm(new  CategoryType(), $category);

        return $this->render('StoreBundle:Category:edit_category.html.twig', array(
            'base_template'   => $this->getBaseTemplate(),
            'admin_pool'      => $this->container->get('sonata.admin.pool'),
            'blocks'          => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks'),
            'id' => $id,
            'form' => $form->createView(),
        ));
    }
}
