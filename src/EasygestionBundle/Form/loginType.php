<?php

namespace EasygestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class loginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //Formulaire
        $builder
                ->add('Pseudo');
        
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => loginType::class,
            'Pseudo' => null,
        ));
    }
    
    //public function getName()
    //{
      //  return 'abylsen_easygestionbundle_login';
    //}
}