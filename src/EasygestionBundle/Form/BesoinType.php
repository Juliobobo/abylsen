<?php

namespace EasygestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BesoinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //Formulaire
        $builder
                ->add('status', ChoiceType::class, array(
                        'choices' => array(
                            'Non actif' => '0',
                            'Actif' => '1',
                        )
                ))
                ->add('priority', ChoiceType::class, array(
                        'choices' => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                        )
                ))
                ->add('client', EntityType::class, array(
                        'class' => 'EasygestionBundle:Client',
                        'choice_label' => 'name',
                ))
                ->add('start', DateType::class, array(
                        'placeholder' => array(
                            'year' => 'Année',
                            'month' => 'Mois',
                            'day' => 'Jour',
                        ),
                        'format' => 'yyyy-MM-dd',
                ))
                ->add('duration', DateIntervalType::class, array(
                        'placeholder' => 'Mois',
                        'with_years'  => false,
                        'with_months' => true,
                        'with_days'   => false,
                        'with_hours'  => false,
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

