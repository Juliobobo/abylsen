<?php

namespace EasygestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccueilController extends Controller
{
    public function loginAction(){
        die('ici');
    }
    
    public function accueilAction()
    {
        return $this->render('EasygestionBundle:Default:accueil.html.twig');
    }
}
