<?php

namespace EasygestionBundle\Controller;

use EasygestionBundle\Datatables\BesoinsDatatable;
use EasygestionBundle\Datatables\ArchivesDatatable;
use EasygestionBundle\Entity\Client;
use EasygestionBundle\Form\ClientType;
use Sg\DatatablesBundle\Datatable\DatatableInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use EasygestionBundle\Entity\Besoin;
use EasygestionBundle\Form\BesoinType;

/**
 * Gestion controller.
 *
 * @Route("gestion")
 *
 * @package EasygestionBundle\Controller
 */
class GestionController extends Controller
{
    /**
     * Lister tous les besoins.
     *
     * @param Request $request
     *
     * @Route("/", name="gestion_index")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * 
     * @return Response
     */
    public function listAllAction(Request $request)
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
            $qb->andWhere('besoin.archive = :archive');
            $qb->setParameter('archive', 0);
            
            return $responseService->getResponse();
        }

        return $this->render('EasygestionBundle:gestion:gestion.html.twig', array(
            'datatable' => $datatable,
        ));
    }
    
    
    /**
     * Liste des besoins d'un IA
     *
     * @param Request $request
     *
     * @Route("/ia", name="besoins_ia", options = {"expose" = true})
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function besoinsIaAction(Request $request)
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
            
            $besoin->setArchive(0);
            
            $em->persist($besoin);
            $em->flush();
            
            if($this->isGranted('ROLE_ADMIN')){
                return $this->redirectToRoute('gestion_index');
            }
            return $this->redirectToRoute('besoins_ia');
        }

        return $this->render('EasygestionBundle:gestion:new.html.twig', array(
            'besoin' => $besoin,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * Archiver un besoin.
     *
     * @param $id
     * @param $besoin
     *
     * @Route("/arch/{id}", name="besoin_archive")
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
        
        if($this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('gestion_index');
        }
        
        return $this->redirectToRoute('besoins_ia');
    }
    
    /**
     * Finds and displays a besoin.
     *
     * @param Besoin $besoin
     *
     * @Route("/{id}", name="besoin_show", options = {"expose" = true})
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function showAction(Besoin $besoin)
    {
        $form = $this->createForm(BesoinType::class, $besoin);
        
        return $this->render('EasygestionBundle:gestion:show.html.twig', array(
            'besoin' => $besoin,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * Displays a form to edit an existing besoin.
     *
     * @param Request $request
     * @param Besoin  $besoin
     *
     * @Route("/{id}/edit", name="besoin_edit", options = {"expose" = true})
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER') and besoin.isOwner(user) or has_role('ROLE_ADMIN')")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, Besoin $besoin)
    {
        $form = $this->createForm(BesoinType::class, $besoin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('EasygestionBundle:gestion:edit.html.twig', array(
            'besoin' => $besoin,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * Remove un client.
     *
     * @param $id
     *
     * @Route("/remclient/{id}", name="client_remove")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     * 
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeClientAction($id){
        
        $em = $this->getDoctrine()->getManager();
        $client = $em->find('EasygestionBundle:Client', $id);

        if (!$client) 
        {
          throw new NotFoundHttpException("Le client n'existe pas !");
        }
        
        $em->remove($client);
        $em->flush();        
        
        return $this->redirect($this->generateUrl('besoins_ia'));
    }

}
