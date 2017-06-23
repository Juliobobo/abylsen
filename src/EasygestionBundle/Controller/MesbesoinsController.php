<?php

namespace EasygestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EasygestionBundle\Entity\Besoin;
use EasygestionBundle\Form\BesoinType;
use Symfony\Component\HttpFoundation\Request;

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
    
    public function addAction(Request $request){
        
        $msg = '';
        $besoin = new Besoin();
        
        $form = $this->createForm(BesoinType::class, $besoin);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            
            //A changer truc de connexion
            $ia = $em->getRepository('EasygestionBundle:Ia')->find(1); 
            $besoin->setIa($ia);
            
            //Prend la date actuelle lors de l'ajout
            $besoin->setDateCreation(new \DateTime('now'));
            $besoin->setArchive(0);
            
            $em->persist($besoin);
            $em->flush();
                
            $msg = 'Besoin ajouté avec succès !';
            
            return $this->redirect($this->generateUrl(
                        'easygestion_mesbesoins',
                        array(
                            'msg' => $msg,
                        )
                ));
        }else{
            $msg = 'Erreur !';
        }
        
        return $this->render('EasygestionBundle:Ia:add.html.twig',
                                array(
                                    'form' => $form->createView(),
                                    'msg' => $msg,
                                ));
    }
    
    public function archiveAction($id){
        
        $em = $this->getDoctrine()->getManager();

        if (isset($id)){
           $besoin = $em->find('EasygestionBundle:Besoin', $id);
           
           if (!$besoin){
               $message = 'Erreur !';
           }
        }else{
            $message = 'Le besoin n\'existe pas';
        }
        
        $besoin->setArchive(1);
        $em->persist($besoin);
        $em->flush();
                
        $message = 'Besoin archivé';
        
        return $this->redirect($this->generateUrl('easygestion_mesbesoins',
                array(
                     'msg' => $message,
                )));
    }
    
    public function editAction($id, Request $request){
        
        $message = '';
        $em = $this->getDoctrine()->getManager();
        
        if (isset($id)){
           $besoin = $em->find('EasygestionBundle:Besoin', $id);
           
           if (!$besoin){
               $message = 'Erreur !';
           }
        }else{
            $message = 'Le besoin n\'existe pas';
        }
        
        $form = $this->createForm(BesoinType::class, $besoin);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            
            //A changer truc de connexion
            $ia = $em->getRepository('EasygestionBundle:Ia')->find(1); 
            $besoin->setIa($ia);
            
            //Prend la date actuelle lors de l'ajout
            $besoin->setDateCreation(new \DateTime('now'));
            
            $em->persist($besoin);
            $em->flush();
                
            $message = 'Besoin modifié avec succès !';
            
            return $this->redirect($this->generateUrl(
                        'easygestion_mesbesoins',
                        array(
                            'msg' => $message,
                        )
                ));
        } else {
            $message = 'Erreur !';
        }
        
        
        return $this->render('EasygestionBundle:Ia:add.html.twig',
                                array(
                                    'besoin' => $besoin,
                                    'form' => $form->createView(),
                                    'msg' => $message,
                                ));
    }
}
