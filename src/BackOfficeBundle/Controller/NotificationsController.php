<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class NotificationsController extends Controller 
{
    /**
     * @Route("/notifications", name="notifications")
     */
    public function fichesAction()
    {
        return $this->render('BackOfficeBundle:Pages:notifications.html.twig');
    }
}