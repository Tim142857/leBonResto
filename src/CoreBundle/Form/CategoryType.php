<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CategoryType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', TextType::class)
                ->add('categoryParent', EntityType::class, array('class' => 'CoreBundle:Category',
                    'required' => false,
                    'placeholder' => ''))
                ->add('display', ChoiceType::class, array(
                    'choices' => array(
                        'No' => 0,
                        'Yes' => 1
                    ),
                    'multiple' => false,
                    'expanded' => true,
                    'data' => 1
                ))
                ->add('zoom', ChoiceType::class, array(
                    'choices' => array(
                        'No' => 0,
                        'Yes' => 1
                    ),
                    'multiple' => false,
                    'expanded' => true,
                    'data' => 1
                ))
                ->add('photo', HiddenType::class, array(
                    'data_class' => null
                ))
                ->add('imageupload', FileType::class, array(
                    'mapped' => false,
                    'required' => false
                ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Category'
        ));
    }

}
