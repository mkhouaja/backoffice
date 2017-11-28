<?php

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\Administrateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;


/**
 * Administrateur controller.
 *
 */
class AdministrateurController extends Controller
{
    /**
     * @Route("/login" ,name="login")
    */
    public function loginAction(Request $request)
    {
         return $this->render('BackOfficeBundle:Pages:login.html.twig');
    }
    

    
}
