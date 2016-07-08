<?php
/**
 * Created by PhpStorm.
 * User: hanzera
 * Date: 11/26/15
 * Time: 11:51 AM
 */

namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use StockBundle\Entity\Category;
use FOS\RestBundle\Controller\Annotations as Rest;
use StoreBundle\Form\CategoryType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;


class CategoryController extends FOSRestController
{
    /**
     * @return array
     * @Rest\View(statusCode=200)
     */
    public function getCategoriesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('StockBundle:Category')->findAll();

        return array('categories' => $categories);
    }

    /**
     * @param Category $category
     * @return array
     * @Rest\View(statusCode=200)
     */
    public function getCategoryAction($id)
    {
        $category = $this->getDoctrine()->getRepository('StockBundle:Category')
            ->find($id);

        return array('category' => $category);
    }

    /**
     * @param Category $category
     * @return array
     * @Rest\View(statusCode=204)
     */
    public function deleteCategoryAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('StockBundle:Category')->find($id);

        $em->remove($categories);
        $em->flush();
    }

    /**
     * @param Category $category
     * @return array
     * @Rest\View(statusCode=201)
     */
    public function newCategoryAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(new CategoryType(), $category);
        $form->handleRequest($request);

        if ($request->getMethod() == 'POST') {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($category);
                $em->flush();
            } else {
                $logger = $this->get('logger');
                $logger->info($form->getErrors());
            }
        }

        return $this->redirectToRoute('view_category');
    }

     /**
     * @return array
     * @Rest\View(statusCode=204)
     */
    public function editCategoryAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('StockBundle:Category')->find($id);
        $form = $this->createForm(new CategoryType(), $category, array('method' => 'PUT'));

        if ($request->getMethod() == 'PUT') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->flush();
            } else {
                $logger = $this->get('logger');
                $logger->info($form->getErrors());
            }
        }

        return $this->redirectToRoute('view_category');
    }
}
