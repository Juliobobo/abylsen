<?php

namespace EasygestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GestionController extends Controller
{
    public function showAction(){
        
        $em = $this->getDoctrine()->getManager();
        
        //Tous IA
        $ia = $em->getRepository('EasygestionBundle:Ia')->findAll(); 
        
        if(null === $ia){
            throw new NotFoundHttpException("Ia doesn't exist");
        }
        
        //Client
        $client = $em->getRepository('EasygestionBundle:Client')->findAll();
        
        //Besoins des ias
        $besoins = $em
                ->getRepository('EasygestionBundle:Besoin')
                ->findBy(array(
                        'ia' => $ia,
                        'client' => $client
                        ));
        
        return $this->render('EasygestionBundle:Gestion:accueil.html.twig',
                                array(
                                    'ia' => $ia,
                                    'besoins' => $besoins,
                                    'client' => $client
                                ));
    }
}
