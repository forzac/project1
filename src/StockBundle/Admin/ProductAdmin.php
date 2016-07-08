<?php
// src/StockBundle/ProductAdmin/ProductAdmin.php

namespace StockBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Validator\ErrorElement;
use StockBundle\Entity\Image;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;

class ProductAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('description')
            ->add('quantity', 'integer', array())
            ->add('images', 'sonata_type_collection', array(
                'cascade_validation' => false,
                'type_options' => array('delete' => false),
            ), array(
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
                    'admin_code' => 'sonata.admin.image'
                )
            )
            ->add('category', 'sonata_type_model', array(
                       'class' => 'StockBundle:Category',
                       'property' => 'name',
                        'required' => true
                       ));
    }
    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', null, array())
            ->add('name', null, array())
            ->add('quantity', null, array())
            ->add('description', null, array());
    }
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, array())
            ->addIdentifier('name', null, array('label' => 'Наименование товара'))
            ->addIdentifier('description', null, array('label' => 'Описание товара'))
            ->add('quantity', null, array())
            ->add('category', 'entity', array(
                'class' => 'StockBundle:Category',
                'property' => 'name',
                'associated_property' => 'name'
            ))
            ->add('images', 'entity', array(
                'class' => 'StockBundle:Image',
                'property' => 'media',
                'associated_property' => 'media'
            ))
            ->add('_action',  'actions', [
                    'actions' => [
                        'edit' => [],
                        'delete' => [],
                    ]
                ]
            );
    }
//    protected function configureRoutes(RouteCollection $collection)
//    {
//        //$collection->remove('create');
//        $collection->remove('delete');
//        $collection->remove('export');
//        $collection->remove('show');
//    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id', null, array())
            ->add('name', null, array())
            ->add('quantity', null, array())
            ->add('description', null, array());;
    }

    public function prePersist($object)
    {
        // fix weird bug with setter object not being call
        $object->setImages($object->getImages());
        parent::prePersist($object);
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($object)
    {
        $object->setImages($object->getImages());
        parent::preUpdate($object);
        // fix weird bug with setter object not being call
    }

    
}
