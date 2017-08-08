<?php

namespace EasygestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Ia controller.
 *
 * @Route("ia")
 *
 * @package EasygestionBundle\Controller
 */
class IaController extends Controller
{
    /**
     * @Route("/", name="home_ia")
     * @Security("has_role('ROLE_USER')")
     * @Method("GET")
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction()
    {
        return $this->render('EasygestionBundle:Ia:home_ia.html.twig');
    }
    
    
    
}
