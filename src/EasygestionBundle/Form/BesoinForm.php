<?php

namespace EasygestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;


class BesoinForm extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        //Formulaire
        $builder
                ->add('status', 'integer')
                ->add('priority', 'integer')
                ->add('dateCreation', 'date', array(
                                                'widget' => 'single_text',
                                                'input' => 'datetime',
                                                'format' => 'dd/MM/yyyy',
                                                'attr' => array('class' => 'date'),
                                               ))
                ->add('start', 'date');
        
    }
    
    public function getName()
    {
        return 'besoinForm';
    }
}

