<?php

namespace EasygestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EasygestionBundle\Entity\Client;
use EasygestionBundle\Form\ClientType;
use Symfony\Component\HttpFoundation\Request;

class ClientController extends Controller
{
    
    public function clientsAction(Request $request)
    {
        
        $em = $this->getDoctrine()->getManager();
        $clients = $em->getRepository('EasygestionBundle:Client')->findAll(); 
        
        if(null === $clients){
            throw new NotFoundHttpException("Client doesn't exist");
        }   
        
        $msg = '';
        $client = new Client();
        
        $form = $this->createForm(ClientType::class, $client);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($client);
            $em->flush();
                
            $msg = 'Client ajouté avec succès !';
            
            return $this->redirect($this->generateUrl(
                        'easygestion_clients',
                        array(
                            'msg' => $msg,
                        )
                ));
        }else{
            $msg = 'Erreur !';
        }
        
        return $this->render('EasygestionBundle:Ia:clients.html.twig',
                                array(
                                    'clients' => $clients,
                                    'form' => $form->createView(),
                                    'msg' => $msg,
                                ));
    }
    
    public function addAction(Request $request){
        
        $msg = '';
        $client = new Client();
        
        $form = $this->createForm(ClientType::class, $client);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($client);
            $em->flush();
                
            $msg = 'Client ajouté avec succès !';
            
            return $this->redirect($this->generateUrl(
                        'easygestion_clients',
                        array(
                            'msg' => $msg,
                        )
                ));
        }else{
            $msg = 'Erreur !';
        }
        
        return $this->render('EasygestionBundle:Ia:clients.html.twig',
                                array(
                                    'form' => $form->createView(),
                                    'msg' => $msg,
                                ));
    }
    
    public function removeAction($id){
        
        $em = $this->getDoctrine()->getManager();
        $besoin = $em->find('EasygestionBundle:Besoin', $id);

        if (!$besoin) 
        {
          throw new NotFoundHttpException("Le besoin n'existe pas !");
        }
        
        $em->remove($besoin);
        $em->flush();        
        
        return $this->redirect($this->generateUrl('easygestion_mesbesoins'));
    }
}
