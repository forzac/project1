<?php
// src/StockBundle/ProductAdmin/CategoryAdmin.php

namespace StockBundle\Admin;

use Sonata\AdminBundle\Admin\Admin as SonataAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CategoryAdmin extends SonataAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', null, array());
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', null, array())
            ->add('name', null, array());
    }

    public function configureShowField(ShowMapper $showMapper){
        $showMapper
            ->add('id', null, array())
            ->add('name', null, array());
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, array('label' => 'Идентификатор'))
            ->addIdentifier('name', null, array('label' => 'Наименование категории'))
            ->add('_action',  'actions', [
                    'actions' => [
                        'edit' => [],
                        'delete' => [],
                    ]
                ]
            );
    }
}
