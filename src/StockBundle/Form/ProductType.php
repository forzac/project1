<?php

namespace StockBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use StockBundle\Form\ImageType;

class ProductType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('description');
        $builder->add('quantity');
        $builder->add('images', 'collection', array(
            'type' => new ImageType(),
            'allow_add' => true,
            'by_reference' => false,
            'allow_delete' => true,
            'prototype' => true

        ));
        $builder->add('save', 'submit', array(
            'label' => 'Создать',
            'attr' => [
                'class' => 'btn btn-success'
        ]));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'StockBundle\Entity\Product',
            'csrf_protection' => false
        ));
    }

    public function getName()
    {
        return 'product';
    }
}
