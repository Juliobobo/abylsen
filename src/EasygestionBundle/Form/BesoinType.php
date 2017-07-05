<?php

namespace EasygestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BesoinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        //Formulaire
        $builder
                ->add('status', ChoiceType::class, array(
                        'placeholder' => 'Quel status ?',
                        'choices' => array(
                            'Non actif' => '0',
                            'Actif' => '1',
                        )
                ))
                ->add('priority', ChoiceType::class, array(
                        'placeholder' => 'Quel priorité ?',
                        'choices' => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                        )
                ))
                ->add('client', EntityType::class, array(
                        'placeholder' => 'Quel client ?',
                        'class' => 'EasygestionBundle:Client',
                        'choice_label' => 'name',
                ))
                ->add('createdBy', EntityType::class, array(
                        'placeholder' => 'Ia ?',
                        'class' => 'EasygestionBundle:Ia',
                        'choice_label' => 'initials',
                ))
                ->add('start', DateType::class, array(
                        'placeholder' => array(
                            'day' => 'Jour',
                            'month' => 'Mois',
                            'year' => 'Année',    
                        ),
                        'format' => 'dd-MM-yyyy',
                ))
                ->add('duration', ChoiceType::class, array(
                        'placeholder' => 'Mois',
                        'choices' => range(0, 12),
                ));
        
    }
    
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EasygestionBundle\Entity\Besoin'
        ));
    }
    
    public function getName()
    {
        return 'besoinForm';
    }
}

