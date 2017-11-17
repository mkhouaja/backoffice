<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller 
{
    /**
     * @Route("/index", name="index")
     */
    public function indexAction()
    {
        return $this->render('BackOfficeBundle:Default:index.html.twig');
    }
}
