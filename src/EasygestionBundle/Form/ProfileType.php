<?php

namespace EasygestionBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        //Formulaire
        $builder
                ->add('initials', null, array(
                    'required' => true,
                )); 
    }
    
    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';

    }
    
    public function getBlockPrefix()
    {
        return 'app_user_profile';
    }
  
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}

