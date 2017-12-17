<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('sku')
            ->add('image', FileType::class, array('label' => 'Image for the Product',
                'data_class' => null,
                'required' => false,

            ))
            ->add('description')
            ->add('price')
            ->add('isActive')
            ->add('quantity')
            ->add('categoryId', EntityType::class, array(
                    'class' => 'AppBundle:category',
                    'placeholder' => 'Choose an category',
                    'choice_label' => 'name',
                    'choice_value' => 'id',
                    'required' => false,
                ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_product';
    }


}
