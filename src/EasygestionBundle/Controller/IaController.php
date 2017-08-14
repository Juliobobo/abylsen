<?php

namespace EasygestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use EasygestionBundle\Datatables\BesoinsDatatable;
use EasygestionBundle\Entity\Besoin;
use EasygestionBundle\Entity\Ia;
use EasygestionBundle\Form\BesoinType;
use EasygestionBundle\Entity\Client;
use EasygestionBundle\Form\ClientType;
use Sg\DatatablesBundle\Datatable\DatatableInterface;

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
        $current_year = date('Y');
        $current_month = (int) date('m');
        
        return $this->render('EasygestionBundle:Ia:home_ia.html.twig', array(
            'c_year' => $current_year,
            'c_month' => $current_month,
        ));
    }
    
    /**
     * Liste des besoins d'un IA
     *
     * @param Request $request
     *
     * @Route("/mesbesoins", name="mes_besoins", options = {"expose" = true})
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function mesBesoinsAction(Request $request)
    {
        $current_year = date('Y');
        $current_month = (int) date('m');
        
        $isAjax = $request->isXmlHttpRequest();
      
        /** @var DatatableInterface $datatable */
        $datatable = $this->get('sg_datatables.factory')->create(BesoinsDatatable::class);
        $datatable->buildDatatable();

        if ($isAjax) {
            $responseService = $this->get('sg_datatables.response');
            $responseService->setDatatable($datatable);

            $datatableQueryBuilder = $responseService->getDatatableQueryBuilder();
            $datatableQueryBuilder->buildQuery();                    
            
            /** @var QueryBuilder $qb */
            $qb = $datatableQueryBuilder->getQb();
            $qb->andWhere('createdBy.initials = :initials');
            $qb->setParameter('initials', $this->getUser()->getInitials());
            
            $qb->andWhere('besoin.archive = :archive');
            $qb->setParameter('archive', 0);

            return $responseService->getResponse();
        }
        
        //Clients
        $em = $this->getDoctrine()->getManager();
        $clients = $em->getRepository('EasygestionBundle:Client')->findAll();
       
        $archive = $em->getRepository('EasygestionBundle:Besoin')->findBy(array(
            'archive' => 1,
        ));
        
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
            
            return $this->redirectToRoute('besoins_ia');
        }
        
        return $this->render('EasygestionBundle:ia/mesbesoins:mesbesoins.html.twig', array(
            'datatable' => $datatable,
            'clients' => $clients,
            'form' => $form->createView(),
            'archive' => $archive,
            'c_year' => $current_year,
            'c_month' => $current_month,
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
        $current_year = date('Y');
        $current_month = (int) date('m');
        $em = $this->getDoctrine()->getManager();
  
        $archive = $em->getRepository('EasygestionBundle:Besoin')->findBy(array(
            'archive' => 1,
        ));
        
        return $this->render('EasygestionBundle:ia/archives:archives.html.twig', array(
            'archive' => $archive,
            'c_year' => $current_year,
            'c_month' => $current_month,
        ));
    }
    
    
    /**
     * Archiver un besoin.
     *
     * @param $id
     * @param $besoin
     *
     * /**@Route("/archive/{id}", name="besoin_archivage")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER') and besoin.isOwner(user) or has_role('ROLE_ADMIN')")
     * 
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function archiveAction($id, Besoin $besoin)
    {
        $em = $this->getDoctrine()->getManager();
        
        if($id == $besoin->getId()){
            $besoin->setArchive(1);
            $em->persist($besoin);
            $em->flush();
        }
        
        return $this->redirectToRoute('mes_besoins');
    }
    
    /**
     * Désarchiver un besoin.
     *
     * @param $id
     * @param $besoin
     *
     * /**@Route("/desarchive/{id}", name="besoin_desarchive")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER') and besoin.isOwner(user) or has_role('ROLE_ADMIN')")
     * 
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function desarchiveAction($id, Besoin $besoin)
    {
        $em = $this->getDoctrine()->getManager();
        
        if($id == $besoin->getId()){
            $besoin->setArchive(0);
            $em->persist($besoin);
            $em->flush();
        }
        
        return $this->redirectToRoute('besoins_archives');
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
        
        return $this->render('EasygestionBundle:ia/mesbesoins:show.html.twig', array(
            'besoin' => $besoin,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * Creates a new Besoin.
     *
     * @param Request $request
     *
     * @Route("/newbesoin", name="besoin_new")
     * @Method({"GET", "POST"})
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request)
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

        return $this->render('EasygestionBundle:ia/mesbesoins:new.html.twig', array(
            'besoin' => $besoin,
            //'ia' => $ia,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * Add and show client
     *
     * @param Request $request
     *
     * @Route("/clients", name="mes_clients")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function clientsAction(Request $request)
    {       
        
        $current_year = date('Y');
        $current_month = (int) date('m');
        
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
            $em->persist($client);
            $em->flush();
            
            return $this->redirectToRoute('mes_clients');
        }
        
        return $this->render('EasygestionBundle:Ia/Clients:clients.html.twig', array(
            'c_year' => $current_year,
            'c_month' => $current_month,
            'clients' => $clients,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * Add and show client
     *
     * @param Client  $client
     * 
     * @Route("/remove/{id}", name="client_remove")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function removeClientAction(Client $client)
    {       
        $em = $this->getDoctrine()->getManager();
        $em->remove($client);
        $em->flush();

        return $this->redirectToRoute('mes_clients');
    }
    
}
