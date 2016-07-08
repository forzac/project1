<?php
/**
 * Created by PhpStorm.
 * User: hanzera
 * Date: 11/18/15
 * Time: 10:43 AM
 */

namespace StockBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sonata\AdminBundle\Controller\CoreController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use StockBundle\Entity\Image;

class ProductController extends CoreController
{
    public function custompageAction(Request $request)
    {

        return $this->render('StockBundle:ProductAdmin:custompage.html.twig', array(
            'base_template'   => $this->getBaseTemplate(),
            'admin_pool'      => $this->container->get('sonata.admin.pool'),
            'blocks'          => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks')
        ));
    }

//    public function uploadAction()
//    {
//        return ['image' => ['size' => 1000]];
//
//        $request = Request::createFromGlobals();
//
//        if ($request->getMethod() == "POST") {
//            $uploaded_file = $request->files->get('files');
//
//                if ($uploaded_file) {
//                    for ($i = 0; $i < count($uploaded_file); $i++) {
//                        $picture1 = new Image();
//                        $picture1->setPath('web/upload/' . $this->processImage($uploaded_file[$i]));
//
//                        $em = $this->getDoctrine()->getEntityManager();
//                        $em->persist($picture1);
//                        $em->flush();
//
//                        $response = 'success';
//                    }
//                } else {
//                    var_dump('ERROR'); die;
//                    $response = 'error';
//                    $response = new Response(json_encode(array('response'=>$response)));
//                    $response->headers->set('Content-Type', 'application/json');
//                    return $response;
//                }
//            }
//
//        return $this->render('StockBundle:ProductAdmin:upload.html.twig', [
//            'base_template'   => $this->getBaseTemplate(),
//            'admin_pool'      => $this->container->get('sonata.admin.pool'),
//            'blocks'          => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks'),
//        ]);
//    }
//
//    public static function processImage(UploadedFile $uploaded_file)
//    {
//        $path = 'upload/';
//        $uploaded_file_info = pathinfo($uploaded_file->getClientOriginalName());
//        $filename = uniqid() . "." .$uploaded_file_info['extension'];
//
//        $uploaded_file->move($path, $filename);
//        return $filename;
//    }
}
