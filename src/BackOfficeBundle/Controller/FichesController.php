<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class FichesController extends Controller 
{
    /**
     * @Route("/fiches", name="fiches")
     */
    public function fichesAction()
    {
        return $this->render('BackOfficeBundle:Pages:fiches.html.twig');
    }
}