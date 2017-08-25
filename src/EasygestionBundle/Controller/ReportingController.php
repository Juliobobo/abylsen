<?php

namespace EasygestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use EasygestionBundle\Entity\Consultant;
use EasygestionBundle\Entity\ConsultantInformations;
use EasygestionBundle\Form\ConsultantType;
use EasygestionBundle\Form\ConsultantInformationsType;
use EasygestionBundle\Entity\Client;
use EasygestionBundle\Entity\FraisIa;
use EasygestionBundle\Form\ClientType;
use EasygestionBundle\Form\FraisManagerType;


/**
 * Bp controller.
 *
 * @Route("report")
 *
 * @package EasygestionBundle\Controller
 */
class ReportingController extends Controller
{
    
    /**
     * 
     * @param Request $request
     * 
     * @Route("/", name="home_report")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"GET", "POST"})
     *
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction(Request $request)
    {
        
        
        return $this->render('EasygestionBundle:Reporting:report.html.twig', array(
        
        ));
    }
}
