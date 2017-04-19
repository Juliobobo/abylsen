<?php

namespace EasygestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DirecteurController extends Controller
{
    public function directeurAction()
    {
        return $this->render('EasygestionBundle:Directeur:directeur.html.twig');
    }
}
