<?php
/**
 * Created by PhpStorm.
 * User: hanzera
 * Date: 12/2/15
 * Time: 11:31 AM
 */

namespace StoreBundle\Form;

use Proxies\__CG__\StockBundle\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
            'attr' => [
                'class' => 'form-control'
            ]
        ));
        $builder->add('description', 'textarea', array(
            'attr' => [
                'class' => 'form-control'
            ]
        ));
        $builder->add('quantity', 'integer', array(
            'attr' => [
                'class' => 'form-control'
            ]
        ));
        $builder->add('category', 'entity', array(
            'class' => 'StockBundle:Category',
            'choice_label' => 'name',
            'attr' => [
                'class' => 'form-control'
            ]
        ));
//        $builder->add('save', 'submit', array(
//            'label' => 'Create',
//            'attr' => [
//                'class' => 'btn btn-success pull-left',
//            ]));
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