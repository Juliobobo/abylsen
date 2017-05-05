<?php

namespace EasygestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EasygestionBundle\Entity\Collaborateurs;

class GestionController extends Controller
{
    public function ajoutAction()
    {
        //Acces à la base
        $em = $this->getDoctrine()->getManager();
        
        $collabo = new Collaborateurs();
        
        //Pousse les données dans la base
        $em->persist($collabo);
        $em->flush();
        
        return $this->render('EasygestionBundle:Ia:ia.html.twig');
    }

}
