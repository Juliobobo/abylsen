<?php

namespace EasygestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EasygestionBundle\Form\loginType;

class LogController extends Controller
{
    public function loginAction(){
        
        $login = new loginType();
        $form = $this->createForm(loginType::class, $login);
        
        return $this->render('EasygestionBundle:Default:test.html.twig', 
                                array('form' => $form->createView()));

    }
}
