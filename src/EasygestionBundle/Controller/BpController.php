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
 * @Route("ia/bp")
 *
 * @package EasygestionBundle\Controller
 */
class BpController extends Controller
{
    public function choiceMonth($param) {
        
        switch ($param){
            case 1:
                $mois_bis = 'Janvier';
                break;
            case 2:
                $mois_bis = 'Février';
                break;
            case 3:
                $mois_bis = 'Mars';
                break;
            case 4:
                $mois_bis = 'Avril';
                break;
            case 5:
                $mois_bis = 'Mai';
                break;
            case 6:
                $mois_bis = 'Juin';
                break;
            case 7:
                $mois_bis = 'Juillet';
                break;
            case 8:
                $mois_bis = 'Août';
                break;
            case 9:
                $mois_bis = 'Septembre';
                break;
            case 10:
                $mois_bis = 'Octobre';
                break;
            case 11:
                $mois_bis = 'Novembre';
                break;
            case 12:
                $mois_bis = 'Décembre';
                break;
        }
        return $mois_bis;
    }
    
    public function form(Request $request, $param, $mois) {

        $form = $this->createForm(FraisManagerType::class, $param);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $param->setMois($mois);
            
            $em->persist($param);
            $em->flush();
          
            return $this->redirectToRoute('home_bp', array(
                'annee' => date('Y'),
                'mois' => (int) date('m'),
            ));
        }
        
        return $form;
    }
    
    /**
     * 
     * @param Request $request
     * 
     * @Route("/{annee}/{mois}", name="home_bp")
     * @Security("has_role('ROLE_USER')")
     * @Method({"GET", "POST"})
     *
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $annee = $request->get('annee');
        $mois = $request->get('mois');
        
        $current_year = date('Y');
        $current_month = (int) date('m');
        
        $ia = $em->getRepository('EasygestionBundle:Ia')->findBy(
                array(
                    'id' => $this->getUser()->getId(),
            )); 
        
        if(null === $ia){
            throw new NotFoundHttpException("Ia doesn't exist");
        }
        
        $besoin = $em->getRepository('EasygestionBundle:Besoin')->findBy(
                array(
                    'createdBy' => $ia,
            )); 
        
        if(null ===  $besoin){
            throw new NotFoundHttpException("Besoin doesn't exist");
        }
        
        $infos = $em->getRepository('EasygestionBundle:ConsultantInformations')->findBy(
                array(
                    'besoin' => $besoin,
                    'annee' => $annee,
                    'mois' => $mois,
            )); 
        
        if(null === $infos){
            throw new NotFoundHttpException("Info doesn't exist");
        }
        
        $frais = new FraisIa();
        
        $form = $this->createForm(FraisManagerType::class, $frais);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $frais->setMois($mois);
            
            $em->persist($frais);
            $em->flush();
          
            return $this->redirectToRoute('home_bp', array(
                'annee' => date('Y'),
                'mois' => (int) date('m'),
            ));
        }
        
        $fraisIa = $em->getRepository('EasygestionBundle:FraisIa')->findBy(
            array(
                'mois' => $mois,
        )); 
        
        return $this->render('EasygestionBundle:Ia/Bp:bp.html.twig', array(
                'infos' => $infos,
                'frais' => $fraisIa,
                'mois' => $this->choiceMonth($mois),
                'annee' => $annee,
                'form' => $form->createView(),
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
        $form = $this->createForm(FraisManagerType::class, $frais);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('home_bp', array(
                'annee' => date('Y'),
                'mois' => (int) date('m'),
            ));
        }

        return $this->render('EasygestionBundle:Ia/Bp:edit.html.twig', array(
            'frais' => $frais,
            'form' => $form->createView(),
        ));
    }
}
