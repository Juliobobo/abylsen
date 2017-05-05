<?php

namespace EasygestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IaController extends Controller
{
    public function iaAction()
    {
        return $this->render('EasygestionBundle:Ia:ia.html.twig');
    }
    
    public function besoinsAction()
    {
        return $this->render('EasygestionBundle:Ia:besoins.html.twig');
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
