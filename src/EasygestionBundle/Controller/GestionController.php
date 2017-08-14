<?php

namespace EasygestionBundle\Controller;

use EasygestionBundle\Datatables\BesoinsDatatable;
use EasygestionBundle\Datatables\BizzDatatable;
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
use Symfony\Component\HttpFoundation\JsonResponse;


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
        $datatable = $this->get('sg_datatables.factory')->create(BizzDatatable::class);
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
    * @param Request $request
    *
    * @Route("/initials", name="select2_ia")
    *
    * @return JsonResponse|Response
    */
   public function select2Ia(Request $request)
   {
       if ($request->isXmlHttpRequest()) {
           $em = $this->getDoctrine()->getManager();
           $users = $em->getRepository('EasygestionBundle:Ia')->findAll();

           $result = array();

           foreach ($users as $user) {
               $result[$user->getId()] = $user->getInitials();
           }

           return new JsonResponse($result);
       }

       return new Response('Bad request.', 400);
   }
    
    /**
     * Creates a new Besoin.
     *
     * @param Request $request
     *
     * @Route("/new", name="gestion_new")
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
            
            return $this->redirectToRoute('gestion_index');
            
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
     * /**@Route("/arch/{id}", name="gestion_archive")
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
        
        return $this->redirectToRoute('gestion_index');    
    }
    
    /**
     * Finds and displays a besoin.
     *
     * @param Besoin $besoin
     *
     * @Route("/{id}", name="gestion_show", options = {"expose" = true})
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
     * @Route("/{id}/edit", name="gestion_edit", options = {"expose" = true})
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
}
