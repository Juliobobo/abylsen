<?php

namespace EasygestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IaController extends Controller
{
    public function iaAction()
    {
        return $this->render('EasygestionBundle:Ia:ia.html.twig');
    }
}
