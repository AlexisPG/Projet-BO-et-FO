<?php

namespace AdminBundle\Form;

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
            ->add('titleFR')
            ->add('titleEN')
            ->add('descriptionFR')
            ->add('descriptionEN')
            ->add('price')
            ->add('quantity')
            ->add('marque', EntityType::class, [
                'class' => 'AdminBundle\Entity\Brand',
                'choice_label' => 'title',
                'placeholder' => 'Choissisez une option'
            ]) // on ajoute la relation entre le produit et la marque
            ->add('categories', EntityType::class, [
                'class' => 'AdminBundle\Entity\Category',
                'choice_label' => 'title',
                'placeholder' => 'Choissisez une option',
                'expanded' => true,
                'multiple' => true,

            ])
            ->add('image', FileType::class,
                [
                    'data_class' => null
                ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'adminbundle_product';
    }


}
