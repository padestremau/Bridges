<?php

namespace Bridges\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PhotoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', 'choice', array('label' => 'Category',
                                            'choices' => array( 'Section' => array(   'home' => 'Home', 
                                                                                        'aboutUs' => 'About us',
                                                                                        'stories' => 'Stories',
                                                                                        'work' => 'The work', 
                                                                                        'volunteer' => 'Volunteer',
                                                                                        'donate' => 'Donate',
                                                                                        'footer' => 'Footer'))))
            ->add('file','file', array('label' => 'File',
                                    'required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bridges\MainBundle\Entity\Photo'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bridges_mainbundle_photo';
    }
}
