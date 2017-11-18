<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class NotificationsController extends Controller 
{
    /**
     * @Route("/notifications", name="notifications")
     */
    public function notificationsAction()
    {
        return $this->render('BackOfficeBundle:Pages:notifications.html.twig');
    }
    /**
     * @Route("/notifications/ajouter")
     */
    public function ajouterNotificationsAction()
    {
        return $this->render('BackOfficeBundle:Pages:ajouter-notification.html.twig');
    }
}