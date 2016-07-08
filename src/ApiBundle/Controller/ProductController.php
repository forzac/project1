<?php
/**
 * Created by PhpStorm.
 * User: hanzera
 * Date: 11/26/15
 * Time: 11:51 AM
 */

namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use StockBundle\Entity\Product;
use FOS\RestBundle\Controller\Annotations as Rest;
use StoreBundle\Form\ProductType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use StockBundle\Entity\Image;
use Symfony\Component\HttpFoundation\JsonResponse;
use Imagick;


class ProductController extends FOSRestController
{
    /**
     * @return array
     * @Rest\View(statusCode=200)
     */
    public function getProductsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('StockBundle:Product')->findAll();

        return array('products' => $products);
    }

    /**
     * @return array
     * @Rest\View(statusCode=200)
     */
    public function getProductAction($id)
    {
        $product = $this->getDoctrine()->getRepository('StockBundle:Product')
            ->find($id);

        return array('product' => $product);
    }

    /**
     * @return array
     * @Rest\View(statusCode=204)
     */
    public function deleteProductAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('StockBundle:Product')->find($id);
        $images = $em->getRepository('StockBundle:Image')->findBy(['product' => $product]);
        $basePath = $this->get('kernel')->getRootDir() . '/../web/';

        if ($images) {
            for ($i = 0; $i < count($images); $i++) {
                $path[$i] = $images[$i]->getPath();
                $thumb[$i] = str_replace('.', '_thumb.', $path[$i]);
                unlink($basePath . $path[$i]);
                unlink($basePath . $thumb[$i]);
            }
        }
        $em->remove($product);
        $em->flush();
    }

    /**
     * @return array
     * @Rest\View(statusCode=201)
     */
    public function newProductAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(new ProductType(), $product);
        $em = $this->getDoctrine()->getManager();

        if ($request->getMethod() == Request::METHOD_POST) {
            $imageRequest = $request->request->get('img_val');
            $form->handleRequest($request);

            if ($form->isValid()) {
                if ($imageRequest) {
                    $this->persistImages($imageRequest, $em, $product);
                }
                $em->persist($product);
                $em->flush();
            } else {
                $logger = $this->get('logger');
                $logger->info($form->getErrors());
            }
        }

        return $this->redirectToRoute('view_products');
        //return ['status' => 'ok'];
    }

    /**
     * @return array
     * @Rest\View(statusCode=204)
     */
    public function editProductAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('StockBundle:Product')->find($id);
        $form = $this->createForm(new ProductType(), $product, array('method' => 'PUT'));


        if ($request->getMethod() == Request::METHOD_PUT) {
            $imageRequest = $request->request->get('img_val');
            $form->handleRequest($request);

            if ($form->isValid()) {
                if ($imageRequest) {
                   $this->persistImages($imageRequest, $em, $product);
                }
                $em->flush();
            } else {
                $logger = $this->get('logger');
                $logger->info($form->getErrors());
            }
        }

        return $this->redirectToRoute('view_products');
    }

    /**
     * Upload images
     *
     * @param Request $request
     * @param null $id
     * @return JsonResponse
     */
    public function uploadAction(Request $request, $id = null)
    {
        if ($request->getMethod() === Request::METHOD_POST) {
            $uploadedFile = $request->files->get('files');
            $files = $this->loadImages($uploadedFile);
        } elseif ($request->getMethod() === Request::METHOD_GET) {
            $em = $this->getDoctrine()->getManager();
            $images = $em->getRepository('StockBundle:Image')->findBy(['product' => $id]);
            $files = $this->loadImages(null,$images);
        }

        return new JsonResponse($files);
    }

    /**
     * Delete image from DB
     * @Rest\View(statusCode=204)
     * @param $id
     * @return array
     */
    public function deleteImageAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $image = $em->getRepository('StockBundle:Image')->find($id);
        $em->remove($image);
        $em->flush();

        return ['status' => 'deleted'];
    }

    /**
     * relocate images in different path
     *
     * @param string $from
     * @param string $image
     * @param string $to
     */
    public function relocateImage($from, $image, $to)
    {
        copy($from . $image, $to . $image);
        unlink($from . $image);
    }

    /**
     * Load and move images to own folder with using services
     *
     * @param null|array $file
     * @param null|array $images
     * @return mixed
     */
    public function loadImages($file = null, $images = null)
    {
        $service = $this->container->get('myImages');
        $files = $service->upload($file, $images);

        return $files;
    }

    /**
     * Add upload images to DB
     *
     * @param string $imageRequest
     * @param object $em
     * @param object $product
     */
    public function persistImages($imageRequest, $em, $product)
    {
        $img = json_decode($imageRequest);
        $images = (array) $img;
        $basePath = $this->get('kernel')->getRootDir() . '/../web/';

        for ($i = 0; $i < count($images['images']); $i++) {
            $image = new Image();
            $image->setPath('upload/' . $images['images'][$i]);
            $product->addImage($image);
            $em->persist($image);

            $thumb = str_replace('.', '_thumb.', $images['images'][$i]);
            $this->relocateImage($basePath . 'upload/temp/', $images['images'][$i], $basePath . 'upload/');
            $this->relocateImage($basePath . 'upload/temp/', $thumb, $basePath . 'upload/');
        }
    }
}
