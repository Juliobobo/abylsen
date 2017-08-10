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
use EasygestionBundle\Form\ClientType;


/**
 * Bp controller.
 *
 * @Route("ia/bp")
 *
 * @package EasygestionBundle\Controller
 */
class BpController extends Controller
{
    /**
     * @Route("/", name="home_bp")
     * @Security("has_role('ROLE_USER')")
     * @Method("GET")
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction()
    {
        $em = $this->getDoctrine()->getManager();
        
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
            )); 
        
        if(null === $infos){
            throw new NotFoundHttpException("Info doesn't exist");
        }
        
        return $this->render('EasygestionBundle:Ia/Bp:bp.html.twig', array(
                'infos' => $infos,
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
          
            return $this->redirectToRoute('home_bp');
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
          
            return $this->redirectToRoute('home_bp');
        }

        return $this->render('EasygestionBundle:Ia/Bp:new.html.twig', array(
            'consultant' => $consultant_infos,
            'form' => $form->createView(),
        ));
    }
    
    
    /**
     * Liste des besoins archives d'un IA
     *
     * @Route("/archives", name="besoins_archives", options = {"expose" = true})
     * @Method({"GET"})
     * @Security("has_role('ROLE_USER')")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function archivesAction()
    {
        $em = $this->getDoctrine()->getManager();
  
        $archive = $em->getRepository('EasygestionBundle:Besoin')->findBy(array(
            'archive' => 1,
        ));
        
        return $this->render('EasygestionBundle:ia:archives.html.twig', array(
            'archive' => $archive,
        ));
    }
    
    /**
     * Finds and displays a besoin.
     *
     * @param Besoin $besoin
     *
     * @Route("/show/{id}", name="besoin_show", options = {"expose" = true})
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function showAction(Besoin $besoin)
    {
        $form = $this->createForm(BesoinType::class, $besoin);
        
        return $this->render('EasygestionBundle:ia:show.html.twig', array(
            'besoin' => $besoin,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * Add and show client
     *
     * @param Request $request
     *
     * @Route("/clients", name="clients", options = {"expose" = true})
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function clientAction(Request $request)
    {       
        //Clients
        $em = $this->getDoctrine()->getManager();
        $clients = $em->getRepository('EasygestionBundle:Client')->findAll();
        
        if(null === $clients){
            throw new NotFoundHttpException("Client doesn't exist");
        }   

        $client = new Client();
        
        $form = $this->createForm(ClientType::class, $client);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($client);
            $em->flush();
            
            return $this->redirectToRoute('homepage');
        }
        
        return $this->render('EasygestionBundle:ia:clients.html.twig', array(
            'clients' => $clients,
            'form' => $form->createView(),
        ));
    }
    /**
     * Creates a new Besoin.
     *
     * @param Request $request
     *
     * @Route("/new", name="besoin_new")
     * @Method({"GET", "POST"})
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newsAction(Request $request)
    {
        $besoin = new Besoin();
        
        $form = $this->createForm(BesoinType::class, $besoin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            // = $em->getRepository('EasygestionBundle:Ia')->findBy(array(
              //  'initials' => $this->getUser()->getInitials(),
            //));
            
            $besoin->setArchive(0);
           // $besoin->setCreatedBy($ia);
            
            $em->persist($besoin);
            $em->flush();
          
            return $this->redirectToRoute('mes_besoins');
        }

        return $this->render('EasygestionBundle:ia:new.html.twig', array(
            'besoin' => $besoin,
            //'ia' => $ia,
            'form' => $form->createView(),
        ));
    }
}
