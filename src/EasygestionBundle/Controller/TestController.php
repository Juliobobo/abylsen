<?php

namespace EasygestionBundle\Controller;

use EasygestionBundle\Datatables\BesoinDatatable;

use Sg\DatatablesBundle\Datatable\DatatableInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Post controller.
 *
 * @Route("besoin")
 *
 * @package EasygestionBundle\Controller
 */
class TestController extends Controller
{
    /**
     * Lists besoins.
     *
     * @param Request $request
     *
     * @Route("/", name="besoin_index")
     * @Method("GET")
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();
      
        /** @var DatatableInterface $datatable */
        $datatable = $this->get('sg_datatables.factory')->create(BesoinDatatable::class);
        $datatable->buildDatatable();

        if ($isAjax) {
            $responseService = $this->get('sg_datatables.response');
            $responseService->setDatatable($datatable);

            $datatableQueryBuilder = $responseService->getDatatableQueryBuilder();
            $datatableQueryBuilder->buildQuery();

            //dump($datatableQueryBuilder->getQb()->getDQL()); die();

            return $responseService->getResponse();
        }

        return $this->render('EasygestionBundle:ia:test.html.twig', array(
            'datatable' => $datatable,
        ));
    }

}
