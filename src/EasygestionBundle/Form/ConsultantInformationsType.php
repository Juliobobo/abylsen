<?php

namespace EasygestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use EasygestionBundle\Repository\BesoinRepository;

class ConsultantInformationsType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $ia = $options['ia'];
                
        //Formulaire
        $builder
                ->add('mois', ChoiceType::class, array(
                        'placeholder' => 'Mois',
                        'choices' => array(
                            'Janvier' => 1,
                            'Février' => 2,
                            'Mars' => 3,
                            'Avril' => 4,
                            'Mai' => 5,
                            'Juin' => 6,
                            'Juillet' => 7,
                            'Août' => 8,
                            'Septembre' => 9,
                            'Octobre' => 10,
                            'Novembre' => 11,
                            'Décembre' => 12,
                        ),
                        'label' => 'Mois de la fiche',
                ))
                ->add('consultant', EntityType::class, array(
                    'placeholder' => 'Quel consultant ?',
                    'class' => 'EasygestionBundle:Consultant',
                    'choice_label' => 'nom',
                    'label' => 'Consultant',
                ))
                ->add('valeur', NumberType::class, array(
                    'label' => 'Valeur', 
                ))
                ->add('salaire', IntegerType::class, array(
                    'label' => 'Salaire',
                ))
                ->add('datePrevisionnelle', DateType::class, array(
                    'placeholder' => array(
                        'day' => 'Jour',
                        'month' => 'Mois',
                        'year' => 'Année',    
                    ),
                    'format' => 'dd-MM-yyyy',
                    'label' => 'Date prévisionnelle',
                ))
                ->add('tjm', NumberType::class, array(
                    'label' => 'TJM',
                ))
                ->add('nbFact', NumberType::class, array(
                    'label' => 'Nombre de jours facturés',
                ))
                ->add('inter', NumberType::class, array(
                    'label' => 'Nombre de jours d\'inter',
                    'required'   => false,
                ))
                ->add('absNr', NumberType::class, array(
                    'label' => 'absNr',
                    'required'   => false,
                ))
                ->add('fraisJour', NumberType::class, array(
                    'label' => 'Frais par jour',
                    'required'   => false,
                ))
                ->add('fraisOne', NumberType::class, array(
                    'label' => 'Frais 1',
                    'required'   => false,
                ))
                ->add('fraisTwo', NumberType::class, array(
                    'label' => 'Frais 2',
                    'required'   => false,
                ))
                ->add('primeBrute', IntegerType::class, array(
                    'label' => 'Prime Brute',
                    'required'   => false,
                ))
                ->add('besoin', EntityType::class, array(
                    'placeholder' => 'Quel besoin ?',
                    'class' => 'EasygestionBundle:Besoin',
                    'choice_label' => 'description',
                    'label' => 'Besoin',
                    'query_builder' => function (BesoinRepository $er) use($ia) {
                        return $er->createQueryBuilder('b')
                                    ->where('b.createdBy = :ia')
                                    ->setParameter('ia', $ia);
                    },
                ));
    }
    
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EasygestionBundle\Entity\ConsultantInformations',
            'ia' => null,
        ));
    }
    
    public function getName()
    {
        return 'consultantInformationsForm';
    }
}

