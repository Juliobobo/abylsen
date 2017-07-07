<?php

namespace EasygestionBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class ProfileController
 *
 * @Route("/profile")
 * @Security("has_role('ROLE_USER')")
 *
 * @package EasygestionBundle\Controller
 */
class ProfileController extends Controller
{
    
    /**
     * Finds and displays a User entity (User Profile).
     *
     * @param Ia $ia
     *
     * @Route("/{id}", name="profil_show", options={"expose"=true})
     * @Method("GET")
     * @ParamConverter("ia", class="EasygestionBundle:Ia")
     *
     * @return Response
     */
    public function showAction(Ia $ia)
    {
        return $this->render('EasygestionBundle:ia:mesbesoins.html.twig', array(
            'ia' => $ia,
        ));
    }
}
