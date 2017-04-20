<?php

namespace EasygestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EasygestionBundle\Form\LoginType;

class AccueilController extends Controller
{
    public function loginAction(){
        $form = $this->createForm(new LoginType());
        
        return $this->render('EasygestionBundle:Default:accueil.html.twig', 
                                array('form' => $form->createView()));
        die('ici');
    }
    
    public function accueilAction()
    {
        return $this->render('EasygestionBundle:Default:accueil.html.twig');
    }
}
