<?php

namespace Bridges\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('label' => 'Title',
                                        'required' => false))
            ->add('content','redactor', array( 
                                            "redactor"=>"admin_story",
                                            'label' => 'Content',
                                            'required' => false
                                            ))
            ->add('orderList', 'text', array('label' => 'Order of appearance',
                                        'required' => false))
            ->add('status', 'choice', array('label' => 'Statut',
                                            'choices' => array( 'Status' => array(   'active' => 'Active', 
                                                                                        'inactive' => 'Inactive'))))
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
            'data_class' => 'Bridges\MainBundle\Entity\Story'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bridges_mainbundle_story';
    }
}
