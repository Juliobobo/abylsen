<?php

namespace EasygestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IaController extends Controller
{
    public function accueilAction()
    {
        return $this->render('EasygestionBundle:Ia:accueil.html.twig');
    }
    
    public function mesbesoinsAction()
    {
        return $this->render('EasygestionBundle:Ia:mesbesoins.html.twig');
    }
    
    public function teamAction()
    {
        return $this->render('EasygestionBundle:Ia:team.html.twig');
    }
    
    public function projectsAction()
    {
        return $this->render('EasygestionBundle:Ia:projects.html.twig');
    }
}
