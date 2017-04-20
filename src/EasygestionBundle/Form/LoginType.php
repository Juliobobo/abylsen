<?php

namespace EasygestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //Formulaire
        $builder
                ->add('Pseudo');
        
    }
    
    public function getName()
    {
        return 'abylsen_easygestionbundle_login';
    }
}