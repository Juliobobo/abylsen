<?php

namespace EasygestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EasygestionBundle\Form\loginType;

class AccueilController extends Controller
{
    public function loginAction(){
        $form = $this->createForm(new loginType());
        
        return $this->render('EasygestionBundle:Default:test.html.twig', 
                                array('form' => $form->createView()));

    }
    
    public function accueilAction()
    {
        return $this->render('EasygestionBundle:Default:accueil.html.twig');
    }
}
