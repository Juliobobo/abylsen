<?php

namespace EasygestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        //Formulaire
        $builder
                ->add('name', TextType::class, array(
                    'label' => 'Nom',
                ));
        
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EasygestionBundle\Entity\Client'
        ));
    }
    
    public function getName()
    {
        return 'ClientForm';
    }
}

