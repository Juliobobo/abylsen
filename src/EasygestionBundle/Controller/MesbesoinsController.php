<?php

namespace EasygestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EasygestionBundle\Entity\Besoin;
use EasygestionBundle\Form\BesoinType;


class MesbesoinsController extends Controller
{
    
    public function mesbesoinsAction()
    {
        
        $em = $this->getDoctrine()->getManager();
        
        //Inital IA
        $ia = $em->getRepository('EasygestionBundle:Ia')->find(1); 
        
        if(null === $ia){
            throw new NotFoundHttpException("Ia doesn't exist");
        }
        
        //Client
        $client = $em->getRepository('EasygestionBundle:Client')->findAll();
        
        //Besoins de l'ia
        $besoins = $em
                ->getRepository('EasygestionBundle:Besoin')
                ->findBy(array(
                        'ia' => $ia,
                        'client' => $client
                        ));
        
        
        
        return $this->render('EasygestionBundle:Ia:mesbesoins.html.twig',
                                array(
                                    'ia' => $ia,
                                    'besoins' => $besoins,
                                    'client' => $client
                                ));
    }
    
    public function addAction(){
        
        $msg = '';
        $besoin = new Besoin();
        
        $form = $this->createForm(BesoinType::class, $besoin);
        
        
        
        /*if($this->get('request')->getMethod() == 'POST'){
            $form->bind($this->get('request'));
            
            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($besoin);
                $em->flush();
                
                $msg = 'Besoin ajouté avec succès !';
            }
        }*/
        
       return $this->render('EasygestionBundle:Ia:test.html.twig',
                                array(
                                    'form' => $form->createView(),
                                    'msg' => $msg,
                                ));
    }
}
