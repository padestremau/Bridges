<?php

namespace Bridges\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'Name',
                                        'required' => false))
            ->add('headerEng', 'text', array('label' => 'Header',
                                        'required' => false))
            ->add('contentEng','redactor', array( 
                                            "redactor"=>"admin_page",
                                            'label' => 'Content',
                                            'required' => false
                                            ))
            ->add('headerEsp', 'text', array('label' => 'Header',
                                        'required' => false))
            ->add('contentEsp','redactor', array( 
                                            "redactor"=>"admin_page",
                                            'label' => 'Content',
                                            'required' => false
                                            ))
            ->add('dataBaseName', 'text', array('label' => 'Name in database'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bridges\MainBundle\Entity\Page'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bridges_mainbundle_page';
    }
}
