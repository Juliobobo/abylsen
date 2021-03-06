<?php

namespace EasygestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
                        'Out' => '0',
                        'Actif' => '1',
                        'Ok' => '2',
                    ),
                    'label' => 'Statut',
                ))
                ->add('createdBy', EntityType::class, array(
                    'placeholder' => 'Ia ?',
                    'class' => 'EasygestionBundle:Ia',
                    'choice_label' => 'initials',
                    'label' => 'IA',
                   
                ))
                ->add('priority', ChoiceType::class, array(
                    'placeholder' => 'Quel priorité ?',
                    'choices' => array(
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                    ),
                    'label' => 'Priorité',
                ))
                ->add('client', EntityType::class, array(
                    'placeholder' => 'Quel client ?',
                    'class' => 'EasygestionBundle:Client',
                    'choice_label' => 'name',
                ))
                ->add('workType', TextType::class, array(
                    'label' => 'Métier',
                ))
                ->add('description', TextareaType::class)
                ->add('start', DateType::class, array(
                    'placeholder' => array(
                        'day' => 'Jour',
                        'month' => 'Mois',
                        'year' => 'Année',    
                    ),
                    'format' => 'dd-MM-yyyy',
                    'label' => 'T0',
                ))
                ->add('duration', ChoiceType::class, array(
                        'placeholder' => 'Mois',
                        'choices' => range(0, 100),
                        'label' => 'Durée',
                ))
                ->add('solution', TextareaType::class);
        
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

