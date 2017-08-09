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
        return $this->render('EasygestionBundle:Ia:home_ia.html.twig');
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
        
        return $this->render('EasygestionBundle:ia:mesbesoins.html.twig', array(
            'datatable' => $datatable,
            'clients' => $clients,
            'form' => $form->createView(),
            'archive' => $archive,
        ));
    }
    
    /**
     * Get all client from Database to show in Select2-Filter.
     *
     * @param Request $request
     *
     * @Route("/clients", name="select2_clients")
     *
     * @return JsonResponse|Response
     */
    public function select2Clients(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $clients = $em->getRepository('EasygestionBundle:Client')->findAll();

            $result = array();

            foreach ($clients as $client) {
                $result[$client->getId()] = $client->getName();
            }

            return new JsonResponse($result);
        }

        return new Response('Bad request.', 400);
    }
    
    /**
     * Get all client from Database to show in Select2-Filter.
     *
     * @param Request $request
     *
     * @Route("/ias", name="select2_ias")
     *
     * @return JsonResponse|Response
     */
    public function select2Ia(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $Ias = $em->getRepository('EasygestionBundle:Ia')->findAll();

            $result = array();

            foreach ($Ias as $Ia) {
                $result[$Ia->getId()] = $Ia->getInitials();
            }

            return new JsonResponse($result);
        }

        return new Response('Bad request.', 400);
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

        return $this->render('EasygestionBundle:ia:new.html.twig', array(
            'besoin' => $besoin,
            //'ia' => $ia,
            'form' => $form->createView(),
        ));
    }
}
