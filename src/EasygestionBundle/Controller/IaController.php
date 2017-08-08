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
}
