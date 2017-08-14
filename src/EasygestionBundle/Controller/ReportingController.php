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
    
    /**
     * Creates a new Consultant.
     *
     * @param Request $request
     *
     * @Route("/newconsultant", name="consultant_new")
     * @Method({"GET", "POST"})
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newConsultantAction(Request $request)
    {
        $consultant = new Consultant();
        
        $form = $this->createForm(ConsultantType::class, $consultant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($consultant);
            $em->flush();
            
            return $this->redirectToRoute('home_bp', array(
                'annee' => date('Y'),
                'mois' => (int) date('m'),
            ));
        }

        return $this->render('EasygestionBundle:Ia/Bp:new.html.twig', array(
            'consultant' => $consultant,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * Creates a new Consultant informations.
     *
     * @param Request $request
     *
     * @Route("/newconsultantinfos", name="consultant_infos_new")
     * @Method({"GET", "POST"})
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newConsultantInformationsAction(Request $request)
    {
        $consultant_infos = new ConsultantInformations();
        
        $form = $this->createForm(ConsultantInformationsType::class, $consultant_infos, array(
            'ia' => $this->getUser(),
        ));
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($consultant_infos);
            $em->flush();
          
            return $this->redirectToRoute('home_bp', array(
                'annee' => date('Y'),
                'mois' => (int) date('m'),
            ));
        }

        return $this->render('EasygestionBundle:Ia/Bp:new.html.twig', array(
            'consultant' => $consultant_infos,
            'form' => $form->createView(),
        ));
    }
   
    /**
     * Displays a form to edit an existing frais.
     *
     * @param Request $request
     * @param FraisIa  $frais
     *
     * @Route("/frais/{id}/edit", name="frais_edit", options = {"expose" = true})
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editFraisAction(Request $request, FraisIa $frais)
    {        
        
        $current_year = date('Y');
        $current_month = (int) date('m');
     
        $form = $this->createForm(FraisManagerType::class, $frais);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('home_bp', array(
                'annee' => date('Y'),
                'mois' => (int) date('m'),
            ));
        }

        return $this->render('EasygestionBundle:Ia/Bp:edit_frais.html.twig', array(
            'c_year' => $current_year,
            'c_month' => $current_month,
            'form' => $form->createView(),
        ));
    }
}
