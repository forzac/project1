<?php
/**
 * Created by PhpStorm.
 * User: hanzera
 * Date: 11/20/15
 * Time: 5:32 PM
 */

namespace StockBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ImageType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', 'file', [
            "required" => FALSE,
            "attr" => array(
                "accept" => "image/*",
                "multiple" => true,
                'class' => 'btn btn-success'
            )
        ]);
        $builder->add('Load image', 'submit', array(
            'label' => 'Load Files',
            'attr' => [
                'class' => 'btn btn-success'
            ]
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'StockBundle\Entity\Image',
        ));
    }

    public function getName()
    {
        return 'images';
    }
}