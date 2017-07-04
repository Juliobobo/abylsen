<?php

namespace EasygestionBundle\Controller;

use EasygestionBundle\Datatables\BesoinsDatatable;
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
 * Post controller.
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
     * @Method("GET")
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

            return $responseService->getResponse();
        }

        return $this->render('EasygestionBundle:ia:mesbesoins.html.twig', array(
            'datatable' => $datatable,
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

            return $this->redirectToRoute('gestion_index', array('id' => $besoin->getId()));
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
     * @Route("/{id}", name="besoin_archive")
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


}
