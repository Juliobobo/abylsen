<?php

namespace EasygestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ConsultantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        //Formulaire
        $builder
                ->add('dateEmbauche', DateType::class, array(
                    'placeholder' => array(
                        'day' => 'Jour',
                        'month' => 'Mois',
                        'year' => 'Année',    
                    ),
                    'format' => 'dd-MM-yyyy',
                    'label' => 'Date d\'embauche',
                ))
                ->add('contrat', TextType::class, array(
                    'label' => 'Contrat',
                ))
                ->add('type', ChoiceType::class, array(
                        'placeholder' => 'Quel type ?',
                        'choices' => array(
                            'Ingénieur' => '0',
                            'Technicien' => '1',
                        ),
                        'label' => 'Type',
                ))
                ->add('nom', TextType::class, array(
                    'label' => 'nom',
                ))
                ->add('prenom', TextType::class, array(
                    'label' => 'prenom',
                ));
    }
    
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EasygestionBundle\Entity\Consultant'
        ));
    }
    
    public function getName()
    {
        return 'consultantForm';
    }
}

