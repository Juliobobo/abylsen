<?php

namespace EasygestionBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class HomeController
 *
 * @package Easygestionundle\Controller
 */
class HomeController extends Controller
{
    
    /**
     * @Route("/", name="homepage")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
     public function indexAction()
    {
        return $this->render('EasygestionBundle:Home:home.html.twig');
    }
    
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
