<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UtilisateursController extends Controller 
{
    /**
     * @Route("/utilisateurs", name="utilisateurs")
     */
    public function utilisateursAction()
    {
        return $this->render('BackOfficeBundle:Pages:utilisateurs.html.twig');
    }
}
