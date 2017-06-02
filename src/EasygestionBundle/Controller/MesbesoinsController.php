<?php

namespace EasygestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MesbesoinsController extends Controller
{
    
    public function mesbesoinsAction()
    {
        return $this->render('EasygestionBundle:Ia:mesbesoins.html.twig');
    }
}
