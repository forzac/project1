<?php

namespace StoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
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
            'data_class' => 'StockBundle\Entity\Category',
            'csrf_protection' => false
        ));
    }

    public function getName()
    {
        return 'category';
    }
}
