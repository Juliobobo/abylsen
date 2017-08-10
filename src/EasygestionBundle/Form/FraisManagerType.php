<?php

namespace EasygestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use EasygestionBundle\Repository\ConsultantInformationsRepository;

class FraisManagerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        //Formulaire
        $builder
                ->add('frais', NumberType::class, array(
                    'label' => 'Frais',
                ))
                ->add('infos', EntityType::class, array(
                    'placeholder' => 'Quel mois ?',
                    'class' => 'EasygestionBundle:ConsultantInformations',
                    'choice_label' => 'mois',
                    'label' => 'Mois',
                    'query_builder' => function (ConsultantInformationsRepository $er) {
                        return $er->createQueryBuilder('i')
                                    ->where('i.annee = :annee')
                                    ->setParameter('annee', (int) date("Y"));
                    },
                ))
                ;
        
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EasygestionBundle\Entity\FraisIa',
        ));
    }
    
    public function getName()
    {
        return 'FraisIaForm';
    }
}

