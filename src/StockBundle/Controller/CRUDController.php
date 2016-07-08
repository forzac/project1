<?php
/**
 * Created by PhpStorm.
 * User: hanzera
 * Date: 11/19/15
 * Time: 12:17 PM
 */

namespace StockBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as CRUD;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CRUDController extends CRUD
{

//    public function createAction()
//    {
//        $request = $this->container->get('request');
//        $routeName = $request->get('_route');
//
//        if ($routeName == "admin_stock_product_create") {
//            $form = $this->generatePage('Product');
//        } elseif ($routeName == "admin_stock_category_create") {
//            $form = $this->generatePage('Category');
//        }
//
//        return $this->render('SonataAdminBundle:CRUD:base_edit_form.html.twig',array(
//                'form' => $form->createView()
//            )
//        );
//    }

//    public function generatePage($entiti) {
//        $em = $this->getDoctrine()->getManager();
//        $path = 'StockBundle\Entity\\' . $entiti;
//        $path_type = 'StockBundle\Form\\' . $entiti . 'Type';
//        $ent = new $path;
//
//        $form = $this->createForm(new  $path_type, $ent);
//
//        $request = Request::createFromGlobals();
//
//        if ($request->isMethod('POST')) {
//            $form->handleRequest($request);
//
//            if ($form->isValid()) {
//                $em->persist($entiti);
//                $em->flush();
//
//                $this->get('session')->getFlashBag()->add('notice', 'Successfully added new ' . $entiti);
//
//                return $this->redirect($this->generateUrl('admin.' . strtolower($entiti) . '.create'));
//            }
//        }
//        return $form;
//    }



    public function editAction($id = null)
    {
        $templateKey = 'edit';

        $id = $this->get('request')->get($this->admin->getIdParameter());
        $object = $this->admin->getObject($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        if (false === $this->admin->isGranted('EDIT', $object)) {
            throw new AccessDeniedException();
        }

        $this->admin->setSubject($object);

        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->admin->getForm();
        $form->setData($object);

        if ($this->getRestMethod() == 'POST') {
            $form->submit($this->get('request'));

            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                try {
                    $object = $this->admin->update($object);

                    if ($this->isXmlHttpRequest()) {
                        return $this->renderJson(array(
                            'result'    => 'ok',
                            'objectId'  => $this->admin->getNormalizedIdentifier($object),
                        ));
                    }

                    $this->addFlash(
                        'sonata_flash_success',
                        $this->admin->trans(
                            'flash_edit_success',
                            array('%name%' => $this->escapeHtml($this->admin->toString($object))),
                            'SonataAdminBundle'
                        )
                    );

                    // redirect to edit mode
                    return $this->redirectTo($object);
                } catch (ModelManagerException $e) {
                   //$this->logModelManagerException($e);

                    $isFormValid = false;
                }
            }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest()) {
                    $this->addFlash(
                        'sonata_flash_error',
                        $this->admin->trans(
                            'flash_edit_error',
                            array('%name%' => $this->escapeHtml($this->admin->toString($object))),
                            'SonataAdminBundle'
                        )
                    );
                }
            } elseif ($this->isPreviewRequested()) {
                // enable the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
                $this->admin->getShow();
            }
        }

        $view = $form->createView();

        // set the theme for the current ProductAdmin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());

        return $this->render($this->admin->getTemplate($templateKey), array(
            'action' => 'edit',
            'form'   => $view,
            'object' => $object,
        ));
    }
}